<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use App\Http\Requests\Admin\Masters\StoreLabRequest;
use App\Http\Requests\Admin\Masters\UpdateLabRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labs = Lab::latest()->get();

        return view('admin.masters.labs')->with(['labs'=> $labs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLabRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['lab_name'] = $input['lab_name'];
            $data['initial'] = $input['initial'];
            $data['created_by'] = Auth::user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            DB::table('labs')->insert($data);
            DB::commit();

            return response()->json(['success'=> 'Lab created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Lab');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lab $lab)
    {
        if ($lab)
        {
            $response = [
                'result' => 1,
                'lab' => $lab,
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
    public function update(UpdateLabRequest $request, Lab $lab)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['lab_name'] = $input['lab_name'];
            $data['initial'] = $input['initial'];
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');

            DB::table('labs')->where('id', $lab->id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Lab updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Lab');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lab $lab)
    {
        try
        {
            DB::beginTransaction();
            $data['deleted_by'] = Auth::user()->id;
            $data['deleted_at'] = date('Y-m-d H:i:s');

            DB::table('labs')->where('id', $lab->id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Lab deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Lab');
        }
    }
}
