<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Auth\AuthRegisterRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRegisterController extends Controller {

    public function send (AuthRegisterRepositoryInterface $rRegister, Request $req) {

        $data = $req->all();

        if ($rRegister->findOneBy([
            ['email', '=', $data['email']]
        ])) {
            return [
                'status' => false,
                'cod' => 403,
                'error' => 'Ja existe um usuario com este email!'
            ];
        }

        if ($rRegister->validateForm($data)) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!',
            ];
        }

        if (!$rRegister->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'created_at' => date('Y-m-d H:i:s'),
        ])) {
            return [
                'status' => false,
                'cod' => 500,
                'error' => 'Não foi possível te registrar neste momento! Favor, tente novamente mais tarde...'
            ];
        }

        $user = $rRegister->findOneBy([
            ['email', '=', $data['email']]
        ]);

        if ($user) {
            $token = $user->createToken($user->email)->plainTextToken;

            return [
                'status' => true,
                'cod' => 200,
                'user'=> $rRegister->findOneBy([
                    ['email', '=', $data['email']]
                ]),
                'token' => $token
            ];
        }

        return [
            'status' => false,
            'cod' => 502,
            'error' => 'Requisição inválida!'
        ];

    }

}
