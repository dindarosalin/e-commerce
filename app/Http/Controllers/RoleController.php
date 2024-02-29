<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function edit($role)
    {
        $role = Role::find($role);
        $permissions = Permission::all();
        return view('roles.form', compact('role', 'permissions'));
    }

    public function update(Request $request, $role)
    {
        $role = Role::find($role);
        $role->syncPermissions($request->permissions);
        return back()->with('status', 'Role updated');
    }
}
