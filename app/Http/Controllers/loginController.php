<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class loginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "password" => "required"
        ]);

        if($validator->failed()){
            response()->json($validator->errors(), 422);
        }
        $credential = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $user = User::where('email', $credential['email'])->first();
        if(!$user){
            return response()->json([
                'status' => 'Failed/Error',
                'massage' => 'Invalid credential email access token'
            ], 401);
        }elseif(!password_verify($credential['password'], $user->password)){
            return response()->json([
                'status' => 'Failed/Error',
                'massage' => 'Invalid credential password access token'
            ], 401);  
        }
        if(!$token = auth()->guard('api')->login($user)){
            return response()->json([
                'status' => 'Failed/Error',
                'message' => 'Invalid credential access token'
            ], 401);
        }
        return response()->json([
	        'status' => 'Success',
	        'message' => 'Success',
	        'token'   => $token,
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ], 200);
    }
}
