<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
      public function register(RegisterRequest $request)
    {

         $validated = $request->validated();

          $users = User::first();

          if (User::where('email', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => ['The email has already been taken.'],
            ]);
         }
        
         $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
            

        // $when = Carbon::now()->addSeconds(10);

        // $user->notify((new RegisterNotification($user))->delay($when));

        //  event(new UserRegister($user));

        //  event(new Registered($user));

        $token  = $user->createToken('myapptoken')->plainTextToken;
        

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];

        return response($response, 201);
    }
}
