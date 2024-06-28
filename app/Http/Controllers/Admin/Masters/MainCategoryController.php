<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\Lab;
use App\Http\Requests\Admin\Masters\StoreMainCategoryRequest;
use App\Http\Requests\Admin\Masters\UpdateMainCategoryRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $main_category = MainCategory::join('labs', 'main_categories.lab_id', '=', 'labs.id')
        ->select('main_categories.*', 'labs.lab_name')
        ->latest()
        ->get();
        $lab_list = Lab::latest()->get();

        return view('admin.masters.mainCategory')->with(['main_category'=> $main_category, 'lab_list' => $lab_list]);
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
    public function store(StoreMainCategoryRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['main_category_name'] = $input['main_category_name'];
            $data['initial'] = $input['initial'];
            $data['type'] = $input['type'];
            $data['interpretation'] = $input['interpretation'];
            $data['lab_id'] = $input['lab_id'];
            $data['created_by'] = Auth::user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            DB::table('main_categories')->insert($data);
            DB::commit();

            return response()->json(['success'=> 'Main Category created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Main Category');
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
    public function edit(MainCategory $maincategory)
    {
        if ($maincategory)
        {
            $response = [
                'result' => 1,
                'maincategory' => $maincategory,
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
    public function update(UpdateMainCategoryRequest $request, MainCategory $maincategory)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['main_category_name'] = $input['main_category_name'];
            $data['initial'] = $input['initial'];
            $data['type'] = $input['type'];
            $data['interpretation'] = $input['interpretation'];
            $data['lab_id'] = $input['lab_id'];
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');

            DB::table('main_categories')->where('id', $maincategory->id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Main Category updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Main Category');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MainCategory $maincategory)
    {
        try
        {
            DB::beginTransaction();
            $data['deleted_by'] = Auth::user()->id;
            $data['deleted_at'] = date('Y-m-d H:i:s');

            DB::table('main_categories')->where('id', $maincategory->id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Main Category deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Main Category');
        }
    }
}
