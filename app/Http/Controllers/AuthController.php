<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function register(Request $request) {
        $fields = $request->validate([
            'nombre_completo' => 'required|string',
            'correo_electronico' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed',
            'rol' => 'required|in:cliente,proveedor',
        ]);

        $user = User::create([
            'nombre_completo' => $fields['nombre_completo'],
            'email' => $fields['correo_electronico'],
            'password' => bcrypt($fields['password']),
            'rol' => $fields['rol'],
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt(['email' => $fields['email'], 'password' => $fields['password']])) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('servicely_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
}
