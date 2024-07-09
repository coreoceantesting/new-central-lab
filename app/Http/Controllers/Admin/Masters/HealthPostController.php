<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Masters\StoreHealthPostRequest;
use App\Http\Requests\Admin\Masters\UpdateHealthPostRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HealthPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = DB::table('health_posts')->whereNull('deleted_at')->orderBy('id','desc')->get();
        return view('admin.masters.healthPost')->with(['lists'=> $lists]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHealthPostRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['health_post_name'] = $input['health_post_name'];
            $data['initial'] = $input['initial'];
            $data['location'] = $input['location'];
            $data['created_by'] = Auth::user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $health_post_id = DB::table('health_posts')->insertGetId($data);

            if (isset($input['medical_officer_name'])) {
                $medicalOfficers = [];
                foreach ($input['medical_officer_name'] as $key => $doctorName) {
                    $medicalOfficers[] = [
                        'health_post_id' => $health_post_id,
                        'medical_officer_name' => $doctorName,
                        'contact_no' => isset($input['contact_no'][$key]) ? $input['contact_no'][$key] : null,
                        'email_id' => isset($input['email_id'][$key]) ? $input['email_id'][$key] : null,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }

                DB::table('medical_officer_details')->insert($medicalOfficers);
            }

            DB::commit();

            return response()->json(['success'=> 'Health Post created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Health Post');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $list = DB::table('health_posts')->where('id', $id)->first();
        $medical_officer_list = DB::table('medical_officer_details')->where('health_post_id', $id)->get();
        if ($list)
        {
            $response = [
                'result' => 1,
                'list' => $list,
                'medical_officer_list' => $medical_officer_list
            ];
        }
        else
        {
            $response = ['result' => 0];
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHealthPostRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['health_post_name'] = $input['health_post_name'];
            $data['initial'] = $input['initial'];
            $data['location'] = $input['location'];
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');

            DB::table('health_posts')->where('id', $id)->update($data);

            DB::table('medical_officer_details')->where('health_post_id', $id)->delete();

            if (isset($input['medical_officer_name'])) {
                $medicalOfficers = [];
                foreach ($input['medical_officer_name'] as $key => $doctorName) {
                    $medicalOfficers[] = [
                        'health_post_id' => $id,
                        'medical_officer_name' => $doctorName,
                        'contact_no' => isset($input['contact_no'][$key]) ? $input['contact_no'][$key] : null,
                        'email_id' => isset($input['email_id'][$key]) ? $input['email_id'][$key] : null,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }

                DB::table('medical_officer_details')->insert($medicalOfficers);
            }

            DB::commit();

            return response()->json(['success'=> 'Health Post updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Health Post');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            DB::beginTransaction();
            $data['deleted_by'] = Auth::user()->id;
            $data['deleted_at'] = date('Y-m-d H:i:s');
            $medical_officer['deleted_at']= date('Y-m-d H:i:s');

            DB::table('health_posts')->where('id', $id)->update($data);
            DB::table('medical_officer_details')->where('health_post_id', $id)->update($medical_officer);
            DB::commit();

            return response()->json(['success'=> 'Health Post deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Lab');
        }
    }

    public function checkHealthPostName(Request $request)
    {
    	$Name = $request->input('health_post_name');
    
    	// Check if the lab name exists in the database
    	$exists = DB::table('health_posts')->where('health_post_name', $Name)->exists();
    
    	// Return JSON response to the client
    	return response()->json(['exists' => $exists]);
    }
}
