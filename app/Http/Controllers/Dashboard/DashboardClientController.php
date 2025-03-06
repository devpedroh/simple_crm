<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Dashboard\DashboardClientRepositoryInterface;
use Illuminate\Http\Request;

class DashboardClientController extends Controller {

    public function get (DashboardClientRepositoryInterface $rClient) {

        return [
            'status' => true,
            'cod' => 200,
            'data' => $rClient->findAll(['locations'])
        ];

    }

    public function view (DashboardClientRepositoryInterface $rClient, $id) {

        if (isset($id)) {
            return [
                'status' => true,
                'cod' => 200,
                'data' => $rClient->findOneBy([
                    ['id', '=', $id]
                ], null, ['*'], 'locations')
            ];
        }

        return [
            'status' => false,
            'cod' => 502,
            'error' => 'Requisição inválida!'
        ];

    }

    public function create (DashboardClientRepositoryInterface $rClient, Request $req) {

        $data = $req->all();

        if ($rClient->findOneBy([
            ['identification', '=', $data['identification']]
        ], null, ['*'], 'locations')) {
            return [
                'status' => false,
                'cod' => 403,
                'error' => 'Ja existe um cliente com este CPF/CNPJ!'
            ];
        }

        $validateForm = $rClient->validateForm($data);
        if ($validateForm->fails()) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!',
            ];
        }

        if ($rClient->create($data, 'locations')) {
            return [
                'status' => true,
                'cod' => 200,
            ];
        }

        return [
            'status' => false,
            'cod' => 502,
            'error' => 'Requisição inválida!'
        ];

    }

    public function update (DashboardClientRepositoryInterface $rClient, $id, Request $req) {

        $data = $req->all();

        if ($rClient->findOneBy([
            ['identification', '=', $data['identification']],
            ['id', '<>', $id]
        ], null, ['*'], 'locations')) {
            return [
                'status' => false,
                'cod' => 403,
                'error' => 'Ja existe um cliente com este CPF/CNPJ!'
            ];
        }

        $data['id'] = $id;
        $validateForm = $rClient->validateForm($data);
        if ($validateForm->fails()) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!',
            ];
        }

        if ($rClient->update($data, $id, null, 'locations')) {
            return [
                'status' => true,
                'cod' => 200,
            ];
        }

        return [
            'status' => false,
            'cod' => 502,
            'error' => 'Requisição inválida!'
        ];

    }

    public function delete (DashboardClientRepositoryInterface $rClient, $id) {

        if (isset($id)) {
            if ($rClient->delete($id, null, 'locations')) {
                return [
                    'status' => true,
                    'cod' => 200,
                ];
            }

            return [
                'status' => true,
                'cod' => 500,
                'error' => 'Não foi possivel deletar este cliente!'
            ];
        }

        return [
            'status' => false,
            'cod' => 502,
            'error' => 'Requisição inválida!'
        ];

    }

}
