<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Lab;
use App\Models\Method;
use App\Http\Requests\Admin\StorePatientRequest;
use App\Http\Requests\Admin\UpdatePatientRequest;
use App\Models\PatientDetail;
use App\Models\TestResult;
use \Mpdf\Mpdf as PDF;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id') // Assuming 'lab' field in 'patient_details' references 'id' in 'labs' table
            ->whereNull('patient_details.deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $lab = $request->input('labnew');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('patient_details.date', [$fromDateTime, $toDateTime]);
        }

        if ($lab) {
            $query->where('patient_details.lab', $lab);
        }

        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $query->where('patient_details.health_post_id', Auth::user()->health_post_id);
        }

        if(Auth::user()->roles->pluck('name')->contains("Lab Technician")){
            $query->where('patient_details.lab', Auth::user()->lab);
        }

        // Select desired fields from both tables
        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name'); // Adjust fields as per your requirement

        // Get the filtered or unfiltered patient list
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();

        $mainCategories = MainCategory::latest()->get();
        $subCategories = DB::table('sub_categories')
            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
            ->select('sub_categories.*', 'main_categories.main_category_name')
            ->whereNull('sub_categories.deleted_at')
            ->get();
        $lab_list = Lab::latest()->get();
        $referance_doc_list = [];
        $health_post_name = "";
        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $referance_doc_list = DB::table('medical_officer_details')->where('health_post_id', Auth::user()->health_post_id)->whereNull('deleted_at')->get();
            $health_post_name = Auth::user()->name;
        }
        return view('admin.patientRegistration',compact('patient_list', 'lab', 'fromDate', 'toDate', 'lab_list', 'subCategories', 'mainCategories','referance_doc_list', 'health_post_name'));
    }

    // public function store(StorePatientRequest $request)
    // {
    //     try
    //     {
    //         DB::beginTransaction();
    //         $input = $request->validated();
    //         $selectedTests = $input['tests'];
    //         $patient_uniqe_id = $input['first_name'].'_'.$input['last_name'].'_'.rand(1000, 9999);
    //         $lab_id = [];
    //         $subCategoryArr = [];
    //         foreach ($selectedTests as $testId) {
    //             $mainCategoryId = SubCategory::find($testId)->main_category;
    //             $lab_id[][$mainCategoryId] = MainCategory::find($mainCategoryId)->lab_id;
    //             $subCategoryArr[][$mainCategoryId] = $testId;
                
    //         }
    //         $unique_lab = array_unique($lab_id);  
    //         foreach($unique_lab as $key=> $lab){                            
    //             $data['patient_uniqe_id'] = $patient_uniqe_id;
    //             $data['first_name'] = $input['first_name'];
    //             $data['middle_name'] = $input['middle_name'];
    //             $data['last_name'] = $input['last_name'];
    //             $data['mob_no'] = $input['mob_no'];
    //             $data['aadhar_no'] = $input['aadhar_no'];
    //             $data['age'] = $input['age'];
    //             $data['gender'] = $input['gender'];
    //             $data['address'] = $input['address'];
    //             $data['tests'] = ($key == $subCategoryArr[$key]) ? implode(',',$subCategoryArr) : '';
    //             $data['main_test'] = $key;
    //             $data['lab'] = $lab;
    //             $data['refering_doctor_name'] = $input['refering_doctor_name'];
    //             $data['date'] = $input['date'];
    //             $data['created_by'] = Auth::user()->id;
    //             $data['created_at'] = date('Y-m-d H:i:s');
    //             DB::table('patient_details')->insert($data);
    //         }
    //         DB::commit();
    //         return response()->json(['success'=> 'Patient Details Store successfully!']);
    //     }
    //     catch(\Exception $e)
    //     {
    //         return $this->respondWithAjax($e, 'creating', 'Patient Details');
    //     }
    // }

    public function create()
    {
        $mainCategories = MainCategory::latest()->get();
        $subCategories = DB::table('sub_categories')
            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
            ->select('sub_categories.*', 'main_categories.main_category_name')
            ->whereNull('sub_categories.deleted_at')
            ->get();
        $lab_list = Lab::latest()->get();
        $referance_doc_list = [];
        $health_post_name = "";
        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $referance_doc_list = DB::table('medical_officer_details')->where('health_post_id', Auth::user()->health_post_id)->whereNull('deleted_at')->get();
            $health_post_name = DB::table('health_posts')->where('id', Auth::user()->health_post_id)->first('health_post_name');
        }
        return view('admin.registerPatient',compact('lab_list', 'subCategories', 'mainCategories','referance_doc_list', 'health_post_name'));
    }

    public function store(StorePatientRequest $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->validated();
            $selectedTests = $input['tests'];
            $selectedDoctors = implode(',', $input['refering_doctor_name']) ;
            $patient_unique_id = $input['first_name'].'_'.$input['last_name'].'_'.rand(1000, 9999);

            $lab_id = [];
            $subCategoryArr = [];

            // Fetch main category and lab for each selected test
            foreach ($selectedTests as $testId) {
                $mainCategoryId = SubCategory::find($testId)->main_category;
                $labId = MainCategory::find($mainCategoryId)->lab_id;

                // Store lab IDs and corresponding main category test IDs
                $lab_id[$mainCategoryId] = $labId;
                $subCategoryArr[$mainCategoryId][] = $testId;
            }

            // Ensure unique combination of main category and lab
            $unique_combinations = [];
            foreach ($lab_id as $mainCategoryId => $lab) {
                $unique_combinations["$mainCategoryId-$lab"] = [
                    'main_category_id' => $mainCategoryId,
                    'lab_id' => $lab,
                    'tests' => implode(',', $subCategoryArr[$mainCategoryId]),
                ];
            }

            // Insert patient details for each unique combination
            foreach ($unique_combinations as $combination) {
                $data = [
                    'patient_uniqe_id' => $patient_unique_id,
                    'first_name' => $input['first_name'],
                    'middle_name' => $input['middle_name'],
                    'last_name' => $input['last_name'],
                    'mob_no' => $input['mob_no'],
                    'aadhar_no' => $input['aadhar_no'],
                    'age' => $input['age'],
                    'gender' => $input['gender'],
                    'address' => $input['address'],
                    'tests' => $combination['tests'],
                    'main_category_id' => $combination['main_category_id'],
                    'lab' => $combination['lab_id'],
                    'refering_doctor_name' => $selectedDoctors,
                    'date' => $input['date'],
                    'health_post_name' => $input['health_post_name'],
                    'health_post_id' => Auth::user()->health_post_id,
                    'created_by' => Auth::user()->id,
                    'created_at' => now(), // Use Laravel helper for current time
                ];

                // Insert data into patient_details table
                PatientDetail::create($data);
            }

            DB::commit();

            return response()->json(['success' => 'Patient Details stored successfully!']);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->respondWithAjax($e, 'creating', 'Patient Details');
        }
    }

    public function edit(Request $request, $id)
    {
        $details = DB::table('patient_details')->where('patient_id', $id)->first();
        $selected_tests = explode(',', $details->tests);
        $selected_doc = explode(',', $details->refering_doctor_name);
        $referance_doc_list = [];
        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $referance_doc_list = DB::table('medical_officer_details')->where('health_post_id', Auth::user()->health_post_id)->whereNull('deleted_at')->get();
        } 
        $mainCategories = MainCategory::latest()->get();
        $subCategories = DB::table('sub_categories')
            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
            ->select('sub_categories.*', 'main_categories.main_category_name')
            ->whereNull('sub_categories.deleted_at')
            ->get();

        $html = '<label class="col-form-label" for="tests">Select Test <span class="text-danger">*</span></label>';
        $html .= '<select class="form-control multiple-select new" name="tests[]" id="tests" multiple disabled>';

        foreach($mainCategories as $mainCategory) {
            $html .= '<optgroup label="'. $mainCategory->main_category_name .'">';
            foreach($subCategories as $subCategory) {
                if($subCategory->main_category === $mainCategory->id) {
                    $html .= '<option value="'. $subCategory->id .'"';
                    if(in_array($subCategory->id, $selected_tests)) {
                        $html .= ' selected';
                    }
                    $html .= '>'. $subCategory->sub_category_name .'</option>';
                }
            }
            $html .= '</optgroup>';
        }

        $html .= '</select>';
        $html .= '<span class="text-danger is-invalid gender_err"></span>';

        $htmlnew = '<label class="col-form-label" for="refering_doctor_name">Health Post MO Name</label>';
        $htmlnew .= '<select class="form-control multiple-select" name="refering_doctor_name[]" id="refering_doctor_name" multiple>';
            foreach($referance_doc_list as $list){
                $htmlnew .= '<option value="'. $list->medical_officer_name .'"';
                if(in_array($list->medical_officer_name, $selected_doc)) {
                    $htmlnew .= ' selected';
                }
                $htmlnew .= '>'. $list->medical_officer_name .'</option>';
            }
        $htmlnew .= '</select>';
        $htmlnew .= '<span class="text-danger is-invalid refering_doctor_name_err"></span>';


        if ($details)
        {
            $response = [
                'result' => 1,
                'details' => $details,
                'html' => $html,
                'htmlnew' => $htmlnew,
            ];
        }
        else
        {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function update(UpdatePatientRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $selectedDoctor = implode(',', $input['refering_doctor_name']);

            $data['first_name'] = $input['first_name'];
            $data['middle_name'] = $input['middle_name'];
            $data['last_name'] = $input['last_name'];
            $data['mob_no'] = $input['mob_no'];
            $data['aadhar_no'] = $input['aadhar_no'];
            $data['age'] = $input['age'];
            $data['gender'] = $input['gender'];
            $data['address'] = $input['address'];
            // $data['tests'] = $selectedTests;
            // $data['lab'] = $input['lab'];
            $data['refering_doctor_name'] = $selectedDoctor;
            $data['date'] = $input['date'];
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');

            DB::table('patient_details')->where('patient_id', $id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Patient Details updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Patient Details');
        }

    }

    public function destroy(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $data['deleted_by'] = Auth::user()->id;
            $data['deleted_at'] = date('Y-m-d H:i:s');

            DB::table('patient_details')->where('patient_id', $id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Patient Details deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Patient Details');
        }
    }

    public function pending_for_receive_list(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id') // Assuming 'lab' field in 'patient_details' references 'id' in 'labs' table
            ->where('patient_details.status', 'pending')
            ->whereNull('patient_details.deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $lab = $request->input('labnew');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('patient_details.date', [$fromDateTime, $toDateTime]);
        }

        if ($lab) {
            $query->where('patient_details.lab', $lab);
        }

        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $query->where('patient_details.health_post_id', Auth::user()->health_post_id);
        }

        if(Auth::user()->roles->pluck('name')->contains("Lab Technician")){
            $query->where('patient_details.lab', Auth::user()->lab);
        }

        // Select desired fields from both tables
        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name'); // Adjust fields as per your requirement

        // Get the filtered or unfiltered patient list
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();

        $mainCategories = MainCategory::latest()->get();

        $subCategories = DB::table('sub_categories')
                            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
                            ->select('sub_categories.*', 'main_categories.main_category_name')
                            ->whereNull('sub_categories.deleted_at')
                            ->get();

        $lab_list = Lab::latest()->get();

        return view('admin.pendingForReceive', compact('patient_list', 'lab_list', 'subCategories', 'mainCategories', 'fromDate', 'toDate'));
    }

    public function rejected_sample_list(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id') // Assuming 'lab' field in 'patient_details' references 'id' in 'labs' table
            ->where('patient_details.status', 'rejected')
            ->orWhere('patient_details.patient_status', 'rejected')
            ->orWhere('patient_details.first_approval_status', 'rejected')
            ->whereNull('patient_details.deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $lab = $request->input('labnew');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('patient_details.date', [$fromDateTime, $toDateTime]);
        }

        if ($lab) {
            $query->where('patient_details.lab', $lab);
        }

        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $query->where('patient_details.health_post_id', Auth::user()->health_post_id);
        }

        if(Auth::user()->roles->pluck('name')->contains("Lab Technician")){
            $query->where('patient_details.lab', Auth::user()->lab);
        }
        
        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name');
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();

        // $patient_list = DB::table('patient_details')
        //             ->where('status', 'rejected')
        //             ->orWhere('patient_status', 'rejected')
        //             ->orWhere('first_approval_status', 'rejected')
        //             ->whereNull('deleted_at')
        //             ->orderBy('patient_id', 'desc')
        //             ->get();


        return view('admin.rejectedSampleList',compact('patient_list', 'fromDate', 'toDate'));
    }

    public function pending_for_received_sample_list(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id')
            ->where('patient_details.status', 'pending')
            ->where('patient_details.patient_status', 'pending')
            ->whereNull('patient_details.deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $lab = $request->input('labnew');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('patient_details.date', [$fromDateTime, $toDateTime]);
        }

        if ($lab) {
            $query->where('patient_details.lab', $lab);
        }

        if (Auth::user()->hasRole('HealthPost')) {
            // Filter by health_post_id if user role is HealthPost
            $query->where('patient_details.health_post_id', Auth::user()->health_post_id);
        } elseif (Auth::user()->hasRole('Lab Technician')) {
            // Filter by lab if user role is Lab Technician
            $query->where('patient_details.lab', Auth::user()->lab);
        }

        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name');
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();

        return view('admin.pendingforreceivesamplelist', compact('patient_list', 'fromDate', 'toDate'));
    }

    public function received_sample_list(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id') // Assuming 'lab' field in 'patient_details' references 'id' in 'labs' table
            ->where('patient_details.status', 'received')
            // ->where('patient_details.patient_status', 'pending')
            ->whereNull('patient_details.deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $lab = $request->input('labnew');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('patient_details.date', [$fromDateTime, $toDateTime]);
        }

        if ($lab) {
            $query->where('patient_details.lab', $lab);
        }

        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $query->where('patient_details.health_post_id', Auth::user()->health_post_id);
        }

        if(Auth::user()->roles->pluck('name')->contains("Lab Technician")){
            $query->where('patient_details.lab', Auth::user()->lab);
        }
        
        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name');
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();

        // $patient_list = DB::table('patient_details')
        // ->where('status', 'pending')
        // ->orwhere('status', 'received')
        // ->where('patient_status', 'pending')
        // ->whereNull('deleted_at')
        // ->orderBy('patient_id', 'desc')
        // ->get();

            // dd($mainCategories, $subCategories);
        return view('admin.receivedSampleList',compact('patient_list','fromDate', 'toDate'));
    }

    public function update_status_received(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            DB::table('patient_details')->where('patient_id', $id)->update([
                'status' => "received",
                'received_by' => Auth::user()->id,
                'received_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Patient status updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Patient status');
        }

    }

    public function approved_status(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            DB::table('patient_details')->where('patient_id', $id)->update([
                'patient_status' => "approved",
                'patient_approval_by' => Auth::user()->name,
                'patient_approval_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Approved successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Approved');
        }

    }

    public function reject_status(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            $remarks = $request->input('remark');
            $remarksString = implode(', ', $remarks);

            DB::table('patient_details')->where('patient_id', $id)->update([
                'patient_status' => "rejected",
                'status' => "rejected",
                'remark' => $remarksString,
                'patient_approval_by' => Auth::user()->name,
                'patient_approval_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Rejected successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Rejected');
        }

    }

    public function approved_sample_list(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id')
            ->where('patient_details.status', 'received')
            ->where('patient_details.patient_status', 'approved')
            ->whereNull('patient_details.deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $lab = $request->input('labnew');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('patient_details.date', [$fromDateTime, $toDateTime]);
        }

        if ($lab) {
            $query->where('patient_details.lab', $lab);
        }
        
        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $query->where('patient_details.health_post_id', Auth::user()->health_post_id);
        }

        if(Auth::user()->roles->pluck('name')->contains("Lab Technician")){
            $query->where('patient_details.lab', Auth::user()->lab);
        }
        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name');
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();

        // $patient_list = DB::table('patient_details')
        // ->where('status', 'received')
        // ->where('patient_status', 'approved')
        // ->whereNull('deleted_at')
        // ->orderBy('patient_id', 'desc')
        // ->get();

            // dd($mainCategories, $subCategories);
        return view('admin.approvedSampleList',compact('patient_list', 'fromDate', 'toDate'));
    }

    public function view(Request $request, $id)
    {
        $details = DB::table('patient_details')->where('patient_id', $id)->first();
        $selected_tests = explode(',', $details->tests);
        $mainCategories = MainCategory::latest()->get();
        $subCategories = DB::table('sub_categories')
            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
            ->select('sub_categories.*', 'main_categories.main_category_name')
            ->whereNull('sub_categories.deleted_at')
            ->get();

        $html = '<label class="col-form-label" for="tests">Select Test <span class="text-danger">*</span></label>';
        $html .= '<select class="form-control multiple-select new" name="tests[]" id="tests" multiple>';

        foreach($mainCategories as $mainCategory) {
            $html .= '<optgroup label="'. $mainCategory->main_category_name .'">';
            foreach($subCategories as $subCategory) {
                if($subCategory->main_category === $mainCategory->id) {
                    $html .= '<option disabled value="'. $subCategory->id .'"';
                    if(in_array($subCategory->id, $selected_tests)) {
                        $html .= ' selected';
                    }
                    $html .= '>'. $subCategory->sub_category_name .'</option>';
                }
            }
            $html .= '</optgroup>';
        }

        $html .= '</select>';
        $html .= '<span class="text-danger is-invalid gender_err"></span>';
        if ($details)
        {
            $response = [
                'result' => 1,
                'details' => $details,
                'html' => $html,
            ];
        }
        else
        {
            $response = ['result' => 0];
        }
        return $response;
    }

    public function put_parameter(Request $request, $id)
    {
        // $patient_detail = DB::table('patient_details')->where('patient_id', $id)->first();
        $patient_detail = PatientDetail::with('labName')->where('patient_id', $id)->first();

        $selected_tests = explode(',', $patient_detail->tests);
        $method_list = Method::latest()->get();

        // Fetch both main and subtests
        $tests = DB::table('sub_categories')
            ->join('main_categories','sub_categories.main_category','=','main_categories.id')
            ->join('methods','sub_categories.method','=','methods.id')
            ->whereIn('sub_categories.id', $selected_tests)
            ->get(['sub_categories.*','methods.method_name','main_categories.main_category_name','main_categories.type', 'main_categories.interpretation']);

        // Organize tests by main test category
        $organizedTests = [];
        foreach ($tests as $test) {
            $mainCategory = $test->main_category_name;
            $organizedTests[$mainCategory]['tests'][] = $test;
            $organizedTests[$mainCategory]['interpretation'] = $test->interpretation;
        }

        // dd($organizedTests);

        return view('admin.putParameter', compact('patient_detail', 'organizedTests', 'method_list'));
    }

    public function storeResults(Request $request, $id)
    {
        $patient_details = DB::table('patient_details')->where('patient_id', $id)->first();

        // Validation
        $request->validate([
            'results.*.*.test_id' => 'required|exists:sub_categories,id',
            'results.*.*.result' => 'required',
        ]);

        // Store in the database
        foreach ($request->results as $mainIndex => $mainResults) {
            foreach ($mainResults as $result) {
                $testId = $result['test_id'];
                $resultValue = $result['result'];

                // Get method and type from the form
                $methodId = $request->input("method_$testId");
                $type = $request->input("type_$testId");

                DB::table('test_result')->insert([
                    'patient_id' => $id,
                    'test_id' => $testId,
                    'result' => $resultValue,
                    'method_id' => $methodId,
                    'type' => $type,
                    'generated_date' => now(),
                    'created_by' => Auth::user()->id,
                    'created_at' => now(),
                ]);
            }
        }

        // Update patient details status
        DB::table('patient_details')->where('patient_id', $id)->update([
            'status' => 'parameter_submitted',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Test results have been stored successfully!',
        ]);
    }

    public function first_verification_list(Request $request)
    {

        $query = DB::table('patient_details')
        ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
        ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id')
        ->where('patient_details.status', 'parameter_submitted')
        ->where('patient_details.patient_status', 'approved')
        ->where('patient_details.first_approval_status', 'pending')
        ->whereNull('patient_details.deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('date', [$fromDateTime, $toDateTime]);
        }
        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name');
        // Get the filtered or unfiltered patient list
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();

        // $patient_list = DB::table('patient_details')
        // ->where('status', 'parameter_submitted')
        // ->where('patient_status', 'approved')
        // ->where('first_approval_status', 'pending')
        // ->whereNull('deleted_at')
        // ->orderBy('patient_id', 'desc')
        // ->get();

            // dd($mainCategories, $subCategories);
        return view('admin.firstVerificationList',compact('patient_list', 'fromDate', 'toDate'));
    }

    public function view_patient_parameter(Request $request, $id)
    {
        $patient_detail = DB::table('patient_details')->where('patient_id', $id)->first();
        $method_list = Method::latest()->get();

        $test_report = DB::table('test_result')
                    ->join('sub_categories', 'test_result.test_id', '=', 'sub_categories.id')
                    ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
                    ->join('methods', 'test_result.method_id', '=', 'methods.id')
                    ->select('test_result.*', 'methods.method_name', 'sub_categories.sub_category_name', 'sub_categories.units', 'sub_categories.bioreferal','sub_categories.from_range', 'sub_categories.to_range' ,'main_categories.main_category_name', 'main_categories.interpretation')
                    ->where('test_result.patient_id', $id)
                    ->get();

        // Organize tests by main test category
        $organizedTests = [];
        foreach ($test_report as $test) {
            $mainCategory = $test->main_category_name;
            $organizedTests[$mainCategory]['tests'][] = $test;
            $organizedTests[$mainCategory]['interpretation'] = $test->interpretation;
        }

        // dd($organizedTests);
        return view('admin.viewPatientParameter', compact('patient_detail', 'organizedTests', 'method_list'));
    }

    public function first_doctor_approved_status(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            DB::table('patient_details')->where('patient_id', $id)->update([
                'first_approval_status' => "approved",
                'first_approval_by' => Auth::user()->id,
                'first_approval_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Approved successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Approved');
        }

    }

    public function first_doctor_reject_status(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $remarks = $request->input('remark');
            $remarksString = implode(', ', $remarks);

            DB::table('patient_details')->where('patient_id', $id)->update([
                'status' => "rejected",
                'first_approval_status' => "rejected",
                'first_approval_remark' => $remarksString,
                'remark' => $remarksString,
                'first_approval_by' => Auth::user()->id,
                'first_approval_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Rejected successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Rejected');
        }

    }

    public function second_verification_list(Request $request)
    {
        $userId = auth()->user()->id;

        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id')
            ->where('patient_details.patient_status', 'approved')
            ->where('patient_details.first_approval_status', 'approved')
            ->where('patient_details.status', 'parameter_submitted')
            ->where('patient_details.second_approval_status', 'pending')
            ->whereNull('patient_details.deleted_at')
            ->whereNotExists(function ($query) use ($userId) {
                $query->select(DB::raw(1))
                    ->from('patient_details as pd_inner')
                    ->whereColumn('pd_inner.patient_id', 'patient_details.patient_id')
                    ->where('pd_inner.first_approval_by', $userId);
            });

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('date', [$fromDateTime, $toDateTime]);
        }

        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name');
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();

        return view('admin.secondVerificationList', compact('patient_list', 'fromDate', 'toDate'));
    }

    public function second_doctor_approved_status(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            DB::table('patient_details')->where('patient_id', $id)->update([
                'second_approval_status' => "approved",
                'second_approval_by' => Auth::user()->id,
                'second_approval_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Approved successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Approved');
        }

    }

    public function second_doctor_reject_status(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            $remarks = $request->input('remarkNew');
            $remarksString = implode(', ', $remarks);

            DB::table('patient_details')->where('patient_id', $id)->update([
                'second_approval_status' => "rejected",
                'second_approval_remark' => $remarksString,
                'remark' => $remarksString,
                'second_approval_by' => Auth::user()->id,
                'second_approval_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Rejected successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Rejected');
        }

    }

    public function doctor_rejected_list(Request $request)
    {

        $query = DB::table('patient_details')
        ->Where('first_approval_status', 'approved')
        ->Where('second_approval_status', 'rejected')
        ->whereNull('deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('date', [$fromDateTime, $toDateTime]);
        }

        // Get the filtered or unfiltered patient list
        $patient_list = $query->orderBy('patient_id', 'desc')->get();

        // $patient_list = DB::table('patient_details')
        // ->where('status', 'parameter_submitted')
        // ->Where('patient_status', 'approved')
        // ->Where('first_approval_status', 'approved')
        // ->Where('second_approval_status', 'rejected')
        // ->whereNull('deleted_at')
        // ->orderBy('patient_id', 'desc')
        // ->get();

            // dd($mainCategories, $subCategories);
        return view('admin.doctorRejectedList',compact('patient_list', 'fromDate', 'toDate'));
    }

    public function generated_report_list(Request $request)
    {
        $query = DB::table('patient_details')
        ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
        ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id')
        ->where('patient_details.status', 'parameter_submitted')
        ->Where('patient_details.patient_status', 'approved')
        ->Where('patient_details.first_approval_status', 'approved')
        ->Where('patient_details.second_approval_status', 'approved')
        ->whereNull('patient_details.deleted_at');

        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');

        if ($fromDate && $toDate) {
            $fromDateTime = $fromDate . ' 00:00:00';
            $toDateTime = $toDate . ' 23:59:59';
            $query->whereBetween('date', [$fromDateTime, $toDateTime]);
        }

        if(Auth::user()->roles->pluck('name')->contains("HealthPost"))
        {
            $query->where('patient_details.health_post_id', Auth::user()->health_post_id);
        }

        if(Auth::user()->roles->pluck('name')->contains("Lab Technician")){
            $query->where('patient_details.lab', Auth::user()->lab);
        }

        $query->select('patient_details.*', 'labs.lab_name', 'main_categories.main_category_name');
        // Get the filtered or unfiltered patient list
        $patient_list = $query->orderBy('patient_details.patient_id', 'desc')->get();
        
        // $patient_list = DB::table('patient_details')
        // ->where('status', 'parameter_submitted')
        // ->Where('patient_status', 'approved')
        // ->Where('first_approval_status', 'approved')
        // ->Where('second_approval_status', 'approved')
        // ->whereNull('deleted_at')
        // ->orderBy('patient_id', 'desc')
        // ->get();

            // dd($mainCategories, $subCategories);
        return view('admin.generatedReportList',compact('patient_list', 'fromDate', 'toDate'));
    }


    public function patientDetails(Request $request, $patient)
    {
        $patientDetail = DB::table('patient_details')
                            ->where('patient_id', $patient)
                            ->whereNull('deleted_at')
                            ->orderBy('patient_id', 'desc')
                            ->first();

        // dd($patientDetail);

        return view('admin.patient-details')->with(['patientDetail' => $patientDetail]);
    }





    public function testReportPdf($id)
    {

        // Data to be passed to the view
        $data['patient_details'] = PatientDetail::with('labName')->where('patient_id', $id)->first();

        // Fetch test results grouped by main category
        $data['patient_report'] = TestResult::with(['test_name.MainCategory', 'method'])
                                            ->where('patient_id', $id)
                                            ->get()
                                            ->groupBy(function ($item) {
                                                return $item->test_name->MainCategory->main_category_name;
                                            });

        // Render the view to a string
        $html = view('testpdf', $data)->render();

        // Create the mPDF document
        $document = new PDF([
            'mode' => 'utf-8',
            'formate' => 'A4',
            'margin_header' => '1',
            'margin_top' => '3',
            'margin_bottom' => '1',
            'margin_footer' => '0',
            'margin_left' => '5',
            'margin_right' => '5',
        ]);

        // Write the rendered HTML content to the PDF
        $document->WriteHTML($html);

        // Set headers for the PDF response
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="test.pdf"'
        ];

        // Output the PDF content directly to the browser
        return response($document->Output('report.pdf', 'S'), 200, $headers);
    }

    public function getLabs(Request $request)
    {
        $testIds = $request->input('testIds');
        $mainCategoryIds = SubCategory::whereIn('id', $testIds)->pluck('main_category')->toArray();
        $labIds = MainCategory::whereIn('id', $mainCategoryIds)->pluck('lab_id')->toArray();
        $labs = Lab::whereIn('id', $labIds)->get();

        return response()->json(['labs' => $labs]);
    }



}
