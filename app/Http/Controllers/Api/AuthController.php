<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => 'Validation Errors',
                'data' => [],
                'errors' => $validator->errors()->first()
            ], 422);
        }

        // auth 
        if(Auth::attempt($validator->validate())) {
            $user = Auth::user();
            $token = $user->createToken('token_api')->plainTextToken;
            return response()->json([
                'status' => true,
                'msg' => 'login berhasil',
                'data' => [
                    'token' => $token
                ],
                'errors' => []
            ], 200);
        } 
        return response()->json([
            'status' => false,
            'msg' => 'Login Error',
            'data' => [],
            'errors' => 'Email atau Password Salah'
        ], 422);
    }
}
