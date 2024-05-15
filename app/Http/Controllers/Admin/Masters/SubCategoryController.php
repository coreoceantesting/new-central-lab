<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Method;
use App\Http\Requests\Admin\Masters\StoreSubCategoryRequest;
use App\Http\Requests\Admin\Masters\UpdateSubCategoryRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $main_category = MainCategory::latest()->get();
        $category_list = DB::table('sub_categories')
        ->join('main_categories', 'sub_categories.main_category', '=', 'main_categories.id')
        ->join('methods', 'sub_categories.method', '=', 'methods.id')
        ->select('sub_categories.*','main_categories.main_category_name', 'methods.method_name')
        ->whereNull('sub_categories.deleted_at')
        ->latest()
        ->get();
        $method_list = Method::latest()->get();

        return view('admin.masters.subCategory')->with(['main_category'=> $main_category, 'category_list'=> $category_list, 'method_list' => $method_list]);
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
    public function store(StoreSubCategoryRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['sub_category_name'] = $input['sub_category_name'];
            $data['units'] = $input['units'];
            $data['bioreferal'] = $input['bioreferal'];
            $data['main_category'] = $input['main_category'];
            $data['method'] = $input['method'];
            $data['created_by'] = Auth::user()->id;
            $data['created_at'] = date('Y-m-d H:i:s');
            DB::table('sub_categories')->insert($data);
            DB::commit();

            return response()->json(['success'=> 'Sub Category created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'Sub Category');
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
    public function edit(SubCategory $subcategory)
    {
        if ($subcategory)
        {
            $response = [
                'result' => 1,
                'subcategory' => $subcategory,
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
    public function update(UpdateSubCategoryRequest $request, SubCategory $subcategory)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $data['sub_category_name'] = $input['sub_category_name'];
            $data['units'] = $input['units'];
            $data['bioreferal'] = $input['bioreferal'];
            $data['main_category'] = $input['main_category'];
            $data['method'] = $input['method'];
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');

            DB::table('sub_categories')->where('id', $subcategory->id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Sub Category updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'Sub Category');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subcategory)
    {
        try
        {
            DB::beginTransaction();
            $data['deleted_by'] = Auth::user()->id;
            $data['deleted_at'] = date('Y-m-d H:i:s');

            DB::table('sub_categories')->where('id', $subcategory->id)->update($data);
            DB::commit();

            return response()->json(['success'=> 'Sub Category deleted successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'deleting', 'Sub Category');
        }
    }
}
