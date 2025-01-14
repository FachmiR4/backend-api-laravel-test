<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class registerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //make validation
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'email'             => 'required|unique:users',
            'password'          => 'required|min:6'
        ]);
        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //create user
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,  
            ], 201);
        }

        //return JSON process insert failed 
        return response()->json([
            'success' => false,
        ], 409);
    }
}
