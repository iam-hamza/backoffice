<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;
use App\Http\Controllers\AppBaseController;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Http\Resources\UserResource;

class UsersController extends AppBaseController
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return  UserResource::collection(User::with('roles')->get());
       
    }

   

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        $user = User::create($request->all());
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);
    
        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get()->pluck('name', 'name');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        User::whereId($request->id)->update([
            'is_active'=>$request->is_active,
        ]);

        return $this->sendSuccess('Updated ');

    }

    public function show(User $user)
    {
        return $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

    /**
     * List of Customer
     * 
     * @return response json customer
     */
    public function allCustomer(){
        $user =User::whereHas(
            'roles', function($q){
                $q->where('name', 'customer');
            }
        )->get();
        return response()->json([
            'customer'=>$user,
        ]);
    }
     /**
     * List of Artist
     * 
     * @return response json customer
     */
    public function allArtist()
    {
        $user =User::whereHas(
            'roles', function($q){
                $q->where('name', 'artist');
            }
        )
        ->with('artist')
        ->get();
        
        return response()->json([
            'artist'=>$user,
        ]);
    }

}
