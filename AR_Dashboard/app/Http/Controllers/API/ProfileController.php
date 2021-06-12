<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\User as UserResource;

use App\Models\User;

class ProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($token)
    {
        $user = User::join('oauth_access_tokens', 'users.id', '=', 'oauth_access_tokens.user_id')
            ->where('oauth_access_tokens.id', $token)
            ->select('users.*')
            ->get()
            ->first();

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }
}
