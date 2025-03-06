<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Auth\AuthLoginRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthLoginController extends Controller {

    public function send (AuthLoginRepositoryInterface $rLogin, Request $req) {

        $data = $req->all();
        if ($rLogin->verifyForm($data)) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!',
            ];
        }

        $user = $rLogin->findOneBy([
            ['email', '=', $data['email']]
        ]);
        if (!$user) {
            return [
                'status' => false,
                'cod' => 403,
                'error' => 'Não existe um usuario com este email!'
            ];
        }

        if (!Hash::check($data['password'], $user->password)) {
            return [
                'status' => false,
                'cod' => 403,
                'error' => 'Email ou senha não correspondentes!'
            ];
        }

        $token = $user->createToken($user->email)->plainTextToken;

        return [
            'status' => true,
            'cod' => 200,
            'user' => $rLogin->findOneBy([
                ['email', '=', $data['email']]
            ], null, ['name', 'email', 'created_at', 'updated_at']),
            'token' => $token
        ];
    }

    public function get (Request $req) {

        $user = $req->user();
        return [
            'status' => true,
            'cod' => 200,
            'user' => $user
        ];

    }

    public function logout (Request $req) {

        $req->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'cod' => 200,
        ]);

    }

}
