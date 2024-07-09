<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Method;
use App\Http\Requests\Admin\Masters\StoreMethodRequest;
use App\Http\Requests\Admin\Masters\UpdateMethodRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $methods = Method::latest()->get();

        return view('admin.masters.methods')->with(['methods'=> $methods]);
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
    public function store(StoreMethodRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['method_name'] = $input['method_name'];
            $data['initial'] = $input['initial'];
            $data['created_by'] = Auth::user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            DB::table('methods')->insert($data);
            DB::commit();

            return response()->json(['success'=> 'Method created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Method');
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
    public function edit(Method $method)
    {
        if ($method)
        {
            $response = [
                'result' => 1,
                'method' => $method,
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
    public function update(UpdateMethodRequest $request, Method $method)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['method_name'] = $input['method_name'];
            $data['initial'] = $input['initial'];
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');

            DB::table('methods')->where('id', $method->id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Method updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Method');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Method $method)
    {
        try
        {
            DB::beginTransaction();
            $data['deleted_by'] = Auth::user()->id;
            $data['deleted_at'] = date('Y-m-d H:i:s');

            DB::table('methods')->where('id', $method->id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Method deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Method');
        }
    }

    public function checkMethodName(Request $request)
    {
        $methodName = $request->input('method_name');

        // Check if the lab name exists in the database
        $exists = Method::where('method_name', $methodName)->exists();

        // Return JSON response to the client
        return response()->json(['exists' => $exists]);
    }
}
