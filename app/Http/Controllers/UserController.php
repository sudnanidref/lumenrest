<?php

namespace App\Http\Controllers;

use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $this->validate($request, [
            'email'     => 'required|unique:users|email',
            'password'  => 'required|min:6'
        ]);

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return response()->json(["message" => "Success !"], 201);
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required|min:6'
        ]);

        $user = User::where('email', $email)->first();

        if(!$user){
            return response()->json(['message' => 'email not register !'], 401);
        }

        $checkHashPassword = Hash::check($password,$user->password);
        if(!$checkHashPassword){
            return response()->json(['message' => 'failed login !'], 401);
        }

        $generateToken = bin2hex(random_bytes(40));
        $user->update([
            'token' => $generateToken
        ]);

        return response()->json($user);
    }
}
