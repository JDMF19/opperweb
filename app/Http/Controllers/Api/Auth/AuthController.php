<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  
    public function login(Request $request){
      
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'El email ingresado no existe en nuestro sistema'], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => '¡Contraseña incorrecta!'], 401);
        }


        // Crear token de acceso
        $tokenResult = $user->createToken('Opperweb Personal Access Client');
        $token = $tokenResult->token;

        if ($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user->api_user(),
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ],200);
    }

    public function logout(Request $request)
    {
        \Auth::guard('api')->user()->token()->revoke();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }

    public function registro(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Crear token de acceso para que no tenga que hacerlo manualmente después de registrarse
        $tokenResult = $user->createToken('Opperweb Personal Access Client');

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user->api_user(),
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ], 201);
    }


   
}
