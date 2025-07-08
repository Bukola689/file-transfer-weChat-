<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
     public function login(LoginRequest $request)
    {
       $validated = $request->validated();

      $user = User::where('email', $validated['email'])->first();

      if(!$user || !Hash::check($validated['password'], $user->password))
      {
          return response(['message'=>'invalid credentials'], 401);
      } else {
        $token  = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        //Cache::put('user');

        return response($response, 200);
      }
    }
}
