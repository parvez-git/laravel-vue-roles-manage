<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function index()
    {
    	return view('admin.dashboard');
    }

    // ROLE
    public function listRole()
    {
    	return Role::with('permissions')->paginate(10); 
    }

    public function storeRole(Request $request)
    {
    	$request->validate([
            'name'	=> 'required|string|max:255|unique:roles'
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->selectedpermissions);

        return response()->json($role, 200);
    }

    public function updateRole(Request $request)
    {
    	$request->validate([
            'name'	=> 'required|string|max:255|unique:roles,name,'.$request->id
        ]);

    	$role = Role::findById($request->id); 
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->selectedpermissions);

        return response()->json($role, 200);
    }

    public function getRoleList()
    {
    	return Role::latest()->get();
    }

    public function deleteRole($id)
    {
        $role = Role::findById($id);
        $role->syncPermissions();
        $role->delete();

        return response()->json($role, 200);
    }

    // PERMISSION
    public function listPermission()
    {
    	return Permission::latest()->get();
    }
    
    public function storePermission(Request $request)
    {
        $request->validate([
            'name'	=> 'required|string|max:255|unique:permissions'
        ]);

        $permission = Permission::create(['name' => $request->name]);
        $permission->assignRole($request->selectedroles);

        return response()->json($permission, 200);
    }

}
