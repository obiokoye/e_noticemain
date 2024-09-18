<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\Auth;


use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $permissionsCategory = PermissionRole::getPermission('Category', Auth::user()->role_id);
        if(empty($permissionsCategory))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $data['permissionsAdd']  = PermissionRole::getPermission('Add Category', Auth::user()->role_id);
        $data['permissionsEdit'] = PermissionRole::getPermission('Edit Category', Auth::user()->role_id);
        $data['permissionsDelete'] = PermissionRole::getPermission('Delete Category', Auth::user()->role_id);

        $categories = Category::getRecord();
        return view('category.index', $data, compact('categories'));
    }

    public function create()
    {
        $permissionsCategory = PermissionRole::getPermission('Add Category', Auth::user()->role_id);
        if(empty($permissionsCategory))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        return view('category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $permissionsCategory = PermissionRole::getPermission('Add Category', Auth::user()->role_id);
        if(empty($permissionsCategory))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $category = $request->validated();

        Category::create([
           'name' => $category['name'],
           'status' => 1,
           'createdBy' => Auth::user()->id,
        ]);

        return redirect()->route('category.index')->with('success', "Category Added Successfully");

    }

    public function edit($id)
    {
        $permissionsCategory = PermissionRole::getPermission('Edit Category', Auth::user()->role_id);
        if(empty($permissionsCategory))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $category = Category::getSingle($id);
        return view('category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $permissionsCategory = PermissionRole::getPermission('Edit Category', Auth::user()->role_id);
        if(empty($permissionsCategory))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $data = $request->validated();
        $category = Category::getSingle($id);
 
        //dd($userrole);
        $category->update([
             'name' => $data['name'],
             'updatedBy' => Auth::user()->id,
        ]);
 
        return redirect()->route('category.index')->with('success', "Category Updated Successfully");
    }

    public function destroy($id)
    {
        $permissionsCategory = PermissionRole::getPermission('Delete Category', Auth::user()->role_id);
        if(empty($permissionsCategory))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $category = Category::getSingle($id);
        $category->status = 0;

        $category->save();

        return redirect()->route('category.index')->with('error', "Category Deleted Successfully");

    }
}
