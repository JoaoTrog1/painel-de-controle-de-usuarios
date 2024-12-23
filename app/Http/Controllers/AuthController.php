<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Realiza o login do usuário via API.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'uid' => 'required|string',
        ]);

        $user = User::where('name', $request->name)->first();
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Senha inválida'], 401);
        }

        if (Carbon::parse($user->validade)->isPast()) {
            return response()->json(['error' => 'Conta expirada'], 403);
        }


        if (is_null($user->uid)) {
            $user->uid = $request->uid;
            $user->save();
        } elseif ($user->uid !== $request->uid) {
            return response()->json(['error' => 'UID inválido'], 409);
        }

        $token = $user->createToken('YourAppName')->plainTextToken;
        
        return response()->json([
            'status' => true,
            'validade' => $user->validade,
            'token' => $token
        ]);
    }

    /**
     * Realiza o logout do usuário.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }
}

