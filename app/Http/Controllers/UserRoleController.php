<?php

namespace App\Http\Controllers;

use App\Models\PermissionRole;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRoleRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Models\Permission;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;


class UserRoleController extends Controller
{
    public function index()
    {
        $permissionsRole = PermissionRole::getPermission('Role', Auth::user()->role_id);
        if(empty($permissionsRole))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $data['permissionsAdd']  = PermissionRole::getPermission('Add Role', Auth::user()->role_id);
        $data['permissionsEdit'] = PermissionRole::getPermission('Edit Role', Auth::user()->role_id);
        $data['permissionsDelete'] = PermissionRole::getPermission('Delete Role', Auth::user()->role_id);

        $userroles = UserRole::getRecord();
        return view('userrole.index', $data, compact('userroles'));
    }

    public function create()
    {
        $permissionsRole = PermissionRole::getPermission('Add Role', Auth::user()->role_id);
        if(empty($permissionsRole))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $getPermission = Permission::getRecord();
        $data['getPermission'] = $getPermission;
        return view('userrole.create', $data);
    }

    public function store(Request $request)
    {
        
        $permissionsRole = PermissionRole::getPermission('Add Role', Auth::user()->role_id);
        if(empty($permissionsRole))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $save = new UserRole;
        $save->name = $request->name;
        $save->status = 1;
        $save->createdBy = Auth::user()->id;
        $save->save();


        PermissionRole::insertUpdateRecord($request->permission_id, $save->id);

        return redirect()->route('userrole.index')->with('success', "User Role Added Successfully");
    }

    public function edit($id)
    {   
        $permissionsRole = PermissionRole::getPermission('Edit Role', Auth::user()->role_id);
        if(empty($permissionsRole))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $userrole = UserRole::getSingle($id);
        $data['getPermission'] = Permission::getRecord();
        $data['getRolePermission'] = PermissionRole::getRolePermission($id);
        return view('userrole.edit',$data,compact('userrole'));
    }

    public function update(Request $request, $id)
    {
        $permissionsRole = PermissionRole::getPermission('Edit Role', Auth::user()->role_id);
        if(empty($permissionsRole))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }
       $save = UserRole::getSingle($id);
       $save->name = $request->name;
       $save->updatedBy = Auth::user()->id;
       $save->save();

       PermissionRole::insertUpdateRecord($request->permission_id, $save->id);

       $notification = array(
        'message' => 'User Role Updated Successfully',
        'alert-type' => 'success'
       );

       return redirect()->route('userrole.index')->with($notification);

    }

    public function destroy($id)
    {
        $permissionsRole = PermissionRole::getPermission('Delete Role', Auth::user()->role_id);
        if(empty($permissionsRole))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $userrole = UserRole::getSingle($id);
        $userrole->status = 0;

        $userrole->save();

        return redirect()->route('userrole.index')->with('error', "User Role Deleted Successfully");

    }
}
