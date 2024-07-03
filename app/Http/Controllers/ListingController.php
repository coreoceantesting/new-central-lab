<?php

namespace App\Http\Controllers;

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

class ListingController extends Controller
{
    public function quality_check_list(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id')
            ->where('patient_details.status', 'received')
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
        return view('admin.qualityCheck.pendingForQualityCheck',compact('patient_list','fromDate', 'toDate'));
    }

    public function patient_approved_list(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id')
            // ->where('patient_details.status', 'received')
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
        // ->where('status', 'pending')
        // ->orwhere('status', 'received')
        // ->where('patient_status', 'pending')
        // ->whereNull('deleted_at')
        // ->orderBy('patient_id', 'desc')
        // ->get();

            // dd($mainCategories, $subCategories);
        return view('admin.qualityCheck.approvedList',compact('patient_list','fromDate', 'toDate'));
    }

    public function patient_rejected_list(Request $request)
    {
        $query = DB::table('patient_details')
            ->leftJoin('labs', 'patient_details.lab', '=', 'labs.id')
            ->leftJoin('main_categories', 'patient_details.main_category_id', '=', 'main_categories.id') // Assuming 'lab' field in 'patient_details' references 'id' in 'labs' table
            // ->where('patient_details.status', 'received')
            ->where('patient_details.patient_status', 'rejected')
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

        return view('admin.qualityCheck.rejectedList',compact('patient_list','fromDate', 'toDate'));
    }

    public function update_status_resampling(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            DB::table('patient_details')->where('patient_id', $id)->update([
                'status' => "resampling",
                'patient_status' => "pending",
                'resampling_by' => Auth::user()->name,
                'resampling_at'=> date('Y-m-d H:i:s')
            ]);
            DB::commit();

            return response()->json(['success'=> 'Patient Details Send For Resampling Successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Patient status');
        }

    }

    public function view_details(Request $request, $id)
    {
        $details = DB::table('patient_details')->where('patient_id', $id)->first();
        $selected_tests = explode(',', $details->tests);
        $lab_list = Lab::latest()->get();
        $mainCategories = MainCategory::latest()->get();
        $subCategories = DB::table('sub_categories')
            ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
            ->select('sub_categories.*', 'main_categories.main_category_name')
            ->whereNull('sub_categories.deleted_at')
            ->get();

        // Prepare structured data for selected tests under each main category
        $selectedTestsByMainCategory = [];
        foreach ($mainCategories as $mainCategory) {
            $selectedTestsByMainCategory[$mainCategory->id] = [
                'main_category' => $mainCategory,
                'sub_categories' => $subCategories->where('main_category', $mainCategory->id)
                                                ->whereIn('id', $selected_tests)
            ];
        }


        return view('admin.viewDetail',compact('details', 'mainCategories', 'subCategories', 'selected_tests', 'lab_list', 'selectedTestsByMainCategory'));
    }

}
