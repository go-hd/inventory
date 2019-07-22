<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function local()
    {
        return response()->json(['user' => auth()->user()]);
    }

    public function oauth()
    {
        return response()->json(auth()->user());
    }

    public function user()
    {
        return ['user' => auth()->user() ];
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            auth()->user()->OauthAccessToken()->delete();
        }
        $response = ['status' => 'OK'];
        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
    }
}
