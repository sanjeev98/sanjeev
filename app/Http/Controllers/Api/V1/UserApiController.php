<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class UserApiController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        auth()->setDefaultDriver('api');
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @param $id
     * @return UserResource
     */
    public function getPost($id)
    {
        return new UserResource(User::findOrFail($id));
    }
}
