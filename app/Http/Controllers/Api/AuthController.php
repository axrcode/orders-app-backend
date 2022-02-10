<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Verificar que exista el correo y que la contraseña sea la correcta
        if ( $user && Hash::check($request->password, $user->password) ) {
            // Generar el Token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'error'         =>  false,
                'msg'           =>  'Usuario logueado',
                'access_token'  =>  $token
            ], 201);
        } else {
            // Contraseña incorrecta
            return response()->json([
                'error' => true,
                'msj'   => 'Credenciales inválidas'
            ], 200);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'msg' => 'Usuario registrado'
        ], 201);
    }

    public function profile()
    {
        $user = Auth::user();

        return response()->json([
            'msg'   => 'Usuario encontrado',
            'data'  => $user
        ], 202);
    }

    public function logout()
    {
        return Auth::user()->tokens()->delete();
    }

    public function refresh(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'access_token'  =>  $request->user()->createToken('api')->plainTextToken
        ]);
    }
}
