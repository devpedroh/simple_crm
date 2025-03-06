<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Dashboard\DashboardClientRepositoryInterface;
use App\Repositories\Contracts\Dashboard\DashboardProductRepositoryInterface;
use App\Repositories\Contracts\Dashboard\DashboardSellRepositoryInterface;
use App\Repositories\Contracts\Dashboard\DashboardSupplierRepositoryInterface;
use App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsPaymentMethodRepositoryInterface;
use App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsPaymentTypeRepositoryInterface;
use Illuminate\Http\Request;

class DashboardSellController extends Controller {

    public function get (DashboardSellRepositoryInterface $rSell) {

        return [
            'status' => true,
            'cod' => 200,
            'data' => $rSell->findAll(['products', 'client'])
        ];

    }

    public function getFormData (DashboardProductRepositoryInterface $rProduct,
                                 DashboardClientRepositoryInterface $rClient,
                                 DashboardSupplierRepositoryInterface $rSupplier,
                                 DashboardUtilsPaymentMethodRepositoryInterface $rPaymentMethod,
                                 DashboardUtilsPaymentTypeRepositoryInterface $rPaymentType
    ) {

        return [
            'status' => true,
            'cod' => 200,
            'data' => [
                'paymentMethods' => $rPaymentMethod->findAll(),
                'paymentTypes' => $rPaymentType->findAll(),
                'clients' => $rClient->findAll(['locations']),
                'suppliers' => $rSupplier->findAll(['locations']),
                'products' => $rProduct->findAll(['weightUnit', 'widthUnit', 'lengthUnit'])
            ]
        ];

    }

    public function view (DashboardSellRepositoryInterface $rSell, $id) {

        if (isset($id)) {
            return [
                'status' => true,
                'cod' => 200,
                'data' => $rSell->findOneBy([
                    ['id', '=', $id]
                ], null, ['*'], 'products')
            ];
        }

        return [
            'status' => false,
            'cod' => 502,
            'error' => 'Requisição inválida!'
        ];

    }

    public function create (DashboardSellRepositoryInterface $rSell, Request $req) {

        $data = $req->all();

        $validateForm = $rSell->validateForm($data);
        if ($validateForm->fails()) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!'
            ];
        }

        if ($rSell->create($data, 'products')) {
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

    public function update (DashboardSellRepositoryInterface $rSell, $id, Request $req) {

        $data = $req->all();

        $data['id'] = $id;
        $validateForm = $rSell->validateForm($data);
        if ($validateForm->fails()) {
            return [
                'status' => false,
                'cod' => 400,
                'error' => 'Preencha os campos do formulário corretamente!'
            ];
        }

        if ($rSell->update($data, $id, null, 'products')) {
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

    public function delete (DashboardSellRepositoryInterface $rSell, $id) {

        if (isset($id)) {
            if ($rSell->delete($id, null, 'products')) {
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
