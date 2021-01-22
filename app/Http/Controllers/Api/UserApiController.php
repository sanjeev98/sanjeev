<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserApiController extends Controller
{
    /**
     * @param $id
     * @return UserResource
     */
    public function getPost($id)
    {
        return new UserResource(User::findOrFail($id));
    }
}
