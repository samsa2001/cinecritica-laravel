<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)){
            $token = Auth::user()->createToken('myapptoken')->plainTextToken;
       

            return response()->json([
                'isLoggedIn' => true,
                'user' => auth()->user(),
                'token' => $token,
            ]);
        }
        return response()->json("Usuario y/o contraseña inválido",422);
    }

    public function checkToken()
    {
        try {
            [$id, $token] = explode('|', request('token'));
            $tokenHash = hash('sha256', $token);
            $tokenModel = PersonalAccessToken::where('token', $tokenHash)->first();

            if ($tokenModel) {
                Auth::login($tokenModel->tokenable);
                return response()->json([
                    'isLoggedIn' => true,
                    'user' => auth()->user(),
                    'token' => request('token'),
                ]);
            }

            //dd($tokenModel->tokenable);

        } catch (\Throwable $th) {
        }

        return response()->json("Usuario inválido", 422);
    }

    public function logout()
    {
        [$id, $token] = explode('|', request('token'));
        if (Auth::user())
            Auth::user()->tokens()->where('id', $id)->delete();
        else
            PersonalAccessToken::where('id', $id)->delete();
        session()->flush();

        return response()->json("OK");
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        
        $token = Auth::user()->createToken('myapptoken')->plainTextToken;
       

        return response()->json([
            'isLoggedIn' => true,
            'user' => auth()->user(),
            'token' => $token,
        ]);
    }
}