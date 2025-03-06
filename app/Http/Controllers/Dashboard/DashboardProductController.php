<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Dashboard\DashboardProductRepositoryInterface;
use App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsUnitRepositoryInterface;
use Illuminate\Http\Request;

class DashboardProductController extends Controller {

    public function get (DashboardProductRepositoryInterface $rProduct) {

        return [
            'status' => true,
            'cod' => 200,
            'data' => $rProduct->findAll(['weightUnit', 'widthUnit', 'lengthUnit'])
        ];

    }

    public function getFormData (DashboardUtilsUnitRepositoryInterface $rUnit) {

        return [
            'status' => true,
            'cod' => 200,
            'data' => [
                'units' => $rUnit->findAll()
            ]
        ];

    }

    public function view (DashboardProductRepositoryInterface $rProduct, $id) {

        if (isset($id)) {
            return [
                'status' => true,
                'cod' => 200,
                'data' => $rProduct->findOneBy([
                    ['id', '=', $id]
                ], null, ['*'])
            ];
        }

        return [
            'status' => false,
            'cod' => 502,
            'error' => 'Requisição inválida!'
        ];

    }

    public function create (DashboardProductRepositoryInterface $rProduct, Request $req) {

        $data = $req->all();

        $validateForm = $rProduct->validateForm($data);
        if ($validateForm->fails()) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!'
            ];
        }

        if ($rProduct->create($data)) {
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

    public function update (DashboardProductRepositoryInterface $rProduct, $id, Request $req) {

        $data = $req->all();

        $data['id'] = $id;
        $validateForm = $rProduct->validateForm($data);
        if ($validateForm->fails()) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!',
            ];
        }

        if ($rProduct->update($data, $id, null)) {
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

    public function delete (DashboardProductRepositoryInterface $rProduct, $id) {

        if (isset($id)) {
            if ($rProduct->delete($id, null)) {
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
