<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AppBaseController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRolesRequest;
use App\Http\Requests\Admin\UpdateRolesRequest;
use Exception;

class RolesController extends AppBaseController
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $roles = Role::with('permissions')->get();

        return response()->json(['roles'=>$roles]);
    }

   

    /**
     * Store a newly created Role in storage.
     *
     * @param  \App\Http\Requests\StoreRolesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
       try{
            $role = Role::create($request->except('permission'));
            $permissions = $request->input('permission') ? $request->input('permission') : [];
            $role->givePermissionTo(json_decode($permissions));

            return $this->sendSuccess('Role Added');
       }catch(Exception $e){

            return $this->sendError($e->getMessage());
       }
       
    }




    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request,Role $role)
    {
        try{
        
            // $role->update($request->except('permission'));
            $permissions = $request->input('permission') ? $request->input('permission') : [];
            $role->syncPermissions(json_decode($permissions));
            
            return $this->sendSuccess('Role Updated');
        }catch(Exception $e){
            return $this->sendError($e->getMessage());
       }
    }

    public function show(Role $role)
    {

        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }


   

}
