<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::whereId(Auth()->user()->id)->with('roles.permissions')->get();
        
        return UserResource::collection($user);
    }
}
