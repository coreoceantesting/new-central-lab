<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Lab;
use App\Http\Requests\Admin\StorePatientRequest;
use App\Http\Requests\Admin\UpdatePatientRequest;
// test config with cpanel using git

class PatientController extends Controller
{
    public function index()
    {
        $patient_list = DB::table('patient_details')->whereNull('deleted_at')->orderBy('patient_id', 'desc')->get();
        $mainCategories = MainCategory::latest()->get();
        $subCategories = DB::table('sub_categories')
            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
            ->select('sub_categories.*', 'main_categories.main_category_name')
            ->whereNull('sub_categories.deleted_at')
            ->get();
        $lab_list = Lab::latest()->get();
            // dd($mainCategories, $subCategories);
        return view('admin.patientRegistration',compact('patient_list', 'lab_list', 'subCategories', 'mainCategories'));
    }

    public function store(StorePatientRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $selectedTests = implode(',', $input['tests']);
            $patient_uniqe_id = $input['first_name'].'_'.$input['last_name'].'_'.rand(1000, 9999);

            $data['patient_uniqe_id'] = $patient_uniqe_id;
            $data['first_name'] = $input['first_name'];
            $data['middle_name'] = $input['middle_name'];
            $data['last_name'] = $input['last_name'];
            $data['mob_no'] = $input['mob_no'];
            $data['aadhar_no'] = $input['aadhar_no'];
            $data['age'] = $input['age'];
            $data['gender'] = $input['gender'];
            $data['address'] = $input['address'];
            $data['tests'] = $selectedTests;
            $data['lab'] = $input['lab'];
            $data['refering_doctor_name'] = $input['refering_doctor_name'];
            $data['date'] = $input['date'];
            $data['created_by'] = Auth::user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            DB::table('patient_details')->insert($data);
            DB::commit();

            return response()->json(['success'=> 'Patient Details Store successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Patient Details');
        }
    }

    public function edit(Request $request, $id)
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

    public function update(UpdatePatientRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $selectedTests = implode(',', $input['tests']);

            $data['first_name'] = $input['first_name'];
            $data['middle_name'] = $input['middle_name'];
            $data['last_name'] = $input['last_name'];
            $data['mob_no'] = $input['mob_no'];
            $data['aadhar_no'] = $input['aadhar_no'];
            $data['age'] = $input['age'];
            $data['gender'] = $input['gender'];
            $data['address'] = $input['address'];
            $data['tests'] = $selectedTests;
            $data['lab'] = $input['lab'];
            $data['refering_doctor_name'] = $input['refering_doctor_name'];
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

    public function pending_for_receive_list()
    {
        $patient_list = DB::table('patient_details')->where('status', 'pending')->whereNull('deleted_at')->orderBy('patient_id', 'desc')->get();
        $mainCategories = MainCategory::latest()->get();
        $subCategories = DB::table('sub_categories')
            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
            ->select('sub_categories.*', 'main_categories.main_category_name')
            ->whereNull('sub_categories.deleted_at')
            ->get();
        $lab_list = Lab::latest()->get();
            // dd($mainCategories, $subCategories);
        return view('admin.pendingForReceive',compact('patient_list', 'lab_list', 'subCategories', 'mainCategories'));
    }

    public function rejected_sample_list()
    {
        $patient_list = DB::table('patient_details')->where('status', 'rejected')->whereNull('deleted_at')->orderBy('patient_id', 'desc')->get();

            // dd($mainCategories, $subCategories);
        return view('admin.rejectedSampleList',compact('patient_list'));
    }

    public function received_sample_list()
    {
        $patient_list = DB::table('patient_details')
        ->where('status', 'pending')
        ->orwhere('status', 'received')
        ->where('patient_status', 'pending')
        ->whereNull('deleted_at')
        ->orderBy('patient_id', 'desc')
        ->get();
        $mainCategories = MainCategory::latest()->get();
        $subCategories = DB::table('sub_categories')
            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
            ->select('sub_categories.*', 'main_categories.main_category_name')
            ->whereNull('sub_categories.deleted_at')
            ->get();
        $lab_list = Lab::latest()->get();

            // dd($mainCategories, $subCategories);
        return view('admin.receivedSampleList',compact('patient_list', 'mainCategories', 'subCategories', 'lab_list'));
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
                // 'received_by' => Auth::user()->id,
                // 'received_at'=> date('Y-m-d H:i:s')
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

            DB::table('patient_details')->where('patient_id', $id)->update([
                'patient_status' => "rejected",
                'status' => "rejected",
                'remark' => $request->input('remark')
                // 'received_by' => Auth::user()->id,
                // 'received_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Rejected successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Rejected');
        }

    }

    public function approved_sample_list()
    {
        $patient_list = DB::table('patient_details')
        ->where('patient_status', 'approved')
        ->whereNull('deleted_at')
        ->orderBy('patient_id', 'desc')
        ->get();

            // dd($mainCategories, $subCategories);
        return view('admin.approvedSampleList',compact('patient_list'));
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


}
