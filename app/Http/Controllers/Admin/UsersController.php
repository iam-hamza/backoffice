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
use App\Http\Requests\Admin\UpdateUserRequest;
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
      return  [
        'role'=>Role::get('name'),
      'users'=>UserResource::collection(User::with('roles')->get()),
      ];
    }

   

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        $input = $request->validated();
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);
    
        return $this->sendSuccess('Created');
    }




    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->validated();
        if($request->has('password')){
            $input['password'] = bcrypt($request->password);
        }
       
        $user->update($input);
        $user->syncRoles($request->roles);
        return $this->sendSuccess('Updated ');

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

        return $this->sendSuccess('Deleted');
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

  

}
