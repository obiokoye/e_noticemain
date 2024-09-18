<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index()
    {
        $permissionsUser = PermissionRole::getPermission('User', Auth::user()->role_id);
        if(empty($permissionsUser))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $data['permissionsAdd']  = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        $data['permissionsEdit'] = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        $data['permissionsDelete'] = PermissionRole::getPermission('Delete User', Auth::user()->role_id);

        $users = User::with(['user_roles', 'departments'])->get();
        return view('users.index',compact('users'));
    }

    public function create()
    {
        $permissionsUser = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        if(empty($permissionsUser))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $departments = Department::getRecord();
        $roles = UserRole::getRecord();
        return view('users.create', compact('departments', 'roles'));
    }

    public function store(Request $request)
    {
        $permissionsUser = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        if(empty($permissionsUser))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'role_id' => 'required|string|max:15',
            'department' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->department = $request->department;
        $user->password =  Hash::make($request->password);
        $user->created_by =  Auth::user()->id;

        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully.');

    }

    public function edit($id)
    {
        $permissionsUser = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        if(empty($permissionsUser))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }
       $user = User::findOrFail($id);
       $department = Department::getRecord();
       $roles = UserRole::getRecord();

       return view('users.edit', compact('user', 'department','roles'));
    }

    public function update(Request $request, $id)
    {
        $permissionsUser = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        if(empty($permissionsUser))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }

        $user = User::findOrFail($id);

        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'role_id' => 'required|string|max:15',
            'department' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->department = $request->department;
        $user->password =  Hash::make($request->password);
        $user->updated_by =  Auth::user()->id;

        $user->update();

        return redirect()->route('user.index')->with('success', 'User Updated successfully.');
    }

    public function destroy($id)
    {
        $permissionsUser = PermissionRole::getPermission('Delete User', Auth::user()->role_id);
        if(empty($permissionsUser))
        {
            return redirect()->route('dashboard')->with('error', "Unauthorized!!! Access Denied");
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('error', 'User deleted successfully.');
    }
}
