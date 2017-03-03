<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use \Auth;

class UserController extends Controller
{
    /**
     * Gets user data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $user = Auth::user();

        return response()->json([$user]);
    }
}
