<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\User as UserResource;

class UserApiController extends Controller
{
    public function getPost($id)
    {
        return new UserResource(User::with('posts')->findOrFail($id));
    }
}
