<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Dashboard\DashboardSupplierRepositoryInterface;
use Illuminate\Http\Request;

class DashboardSupplierController extends Controller {

    public function get (DashboardSupplierRepositoryInterface $rSupplier) {

        return [
            'status' => true,
            'cod' => 200,
            'data' => $rSupplier->findAll(['locations'])
        ];

    }

    public function view (DashboardSupplierRepositoryInterface $rSupplier, $id) {

        if (isset($id)) {
            return [
                'status' => true,
                'cod' => 200,
                'data' => $rSupplier->findOneBy([
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

    public function create (DashboardSupplierRepositoryInterface $rSupplier, Request $req) {

        $data = $req->all();

        if ($rSupplier->findOneBy([
            ['identification', '=', $data['identification']]
        ], null, ['*'], 'locations')) {
            return [
                'status' => false,
                'cod' => 403,
                'error' => 'Ja existe um fornecedor com este CPF/CNPJ!'
            ];
        }

        $validateForm = $rSupplier->validateForm($data);
        if ($validateForm->fails()) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!'
            ];
        }

        if ($rSupplier->create($data, 'locations')) {
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

    public function update (DashboardSupplierRepositoryInterface $rSupplier, $id, Request $req) {

        $data = $req->all();

        if ($rSupplier->findOneBy([
            ['identification', '=', $data['identification']],
            ['id', '<>', $id]
        ], null, ['*'], 'locations')) {
            return [
                'status' => false,
                'cod' => 403,
                'error' => 'Ja existe um fornecedor com este CPF/CNPJ!'
            ];
        }

        $data['id'] = $id;
        $validateForm = $rSupplier->validateForm($data);
        if ($validateForm->fails()) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!'
            ];
        }

        if ($rSupplier->update($data, $id, null, 'locations')) {
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

    public function delete (DashboardSupplierRepositoryInterface $rSupplier, $id) {

        if (isset($id)) {
            if ($rSupplier->delete($id, null, 'locations')) {
                return [
                    'status' => true,
                    'cod' => 200,
                ];
            }

            return [
                'status' => true,
                'cod' => 500,
                'error' => 'Não foi possivel deletar este fornecedor!'
            ];
        }

        return [
            'status' => false,
            'cod' => 502,
            'error' => 'Requisição inválida!'
        ];

    }

}
