<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'email'  =>'required|email',
            'password' =>'required',
            'device_name' =>'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(! $user || ! Hash::check($request->password, $user->password)){
            return response()->json([
                'message'=>'Las credenciales estan incorrectas'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'data'=>[
                'attributes'=>[
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'email'=>$user->email,
                ], 
                'token' =>$user->createToken($request->device_name)->plainTextToken,
            ]
        ], Response::HTTP_OK);
    }
}
