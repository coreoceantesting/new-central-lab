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

class PatientController extends Controller
{
    public function index()
    {
        $patient_list = DB::table('patient_details')->where('status', 'pending')->orderBy('patient_id', 'desc')->get();
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

            $data['patient_name'] = $input['patient_name'];
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
        if ($details)
        {
            $response = [
                'result' => 1,
                'details' => $details,
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

            $data['patient_name'] = $input['patient_name'];
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
}
