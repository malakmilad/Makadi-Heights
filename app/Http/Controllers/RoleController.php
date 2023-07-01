<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::where('name','!=','super admin')->get();
        $permissions = Permission::all();
        return view('roles.index',compact('roles','permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $role_permissions = $role->permissions;
        $permissions = Permission::all();

        $payment_permissions = collect();
        $faqs_permissions = collect();
        $users_permissions = collect();
        $rates_permissions = collect();

        foreach ($permissions as $key => $permission) {
            if (strpos($permission->name, 'payment') !== false){
                $payment_permissions->push($permission);
            }
            if (strpos($permission->name, 'faq') !== false){
                $faqs_permissions->push($permission);
            }
            if (strpos($permission->name, 'user') !== false){
                $users_permissions->push($permission);
            }
            if (strpos($permission->name, 'rates') !== false){
                $rates_permissions->push($permission);
            }
        }

        return view('roles.edit',compact ('role','payment_permissions','faqs_permissions','users_permissions','rates_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($request->id);
        // $role->
        $role->syncPermissions($request->get('permission'));
        // dd($request->all());

        return redirect()
            ->route('roles.edit',$role->id)
            ->with('status', 'Role Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($request->id);

        $role->delete();

        return redirect()
            ->route('roles')
            ->with('status', 'Role Deleted Successfully');
    }
}
