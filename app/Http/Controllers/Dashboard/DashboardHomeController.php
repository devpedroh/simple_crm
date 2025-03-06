<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\Dashboard\DashboardClientRepositoryInterface;
use App\Repositories\Contracts\Dashboard\DashboardProductRepositoryInterface;
use App\Repositories\Contracts\Dashboard\DashboardSellRepositoryInterface;
use App\Repositories\Contracts\Dashboard\DashboardSupplierRepositoryInterface;

class DashboardHomeController extends Controller {

    public function get (DashboardClientRepositoryInterface $rClient,
                         DashboardSupplierRepositoryInterface $rSupplier,
                         DashboardProductRepositoryInterface $rProduct,
                         DashboardSellRepositoryInterface $rSell
    ) {

        return [
            'status' => true,
            'cod' => 200,
            'data' => [
                'clients' => $rClient->findAll()->count(),
                'clients_today' => $rClient->findBy([
                    ['created_at', '>=', date('Y-m-d') . ' 00:00:00'],
                    ['created_at', '<=', date('Y-m-d') . ' 23:59:59']
                ])->count(),
                'suppliers' => $rSupplier->findAll()->count(),
                'suppliers_today' => $rSupplier->findBy([
                    ['created_at', '>=', date('Y-m-d') . ' 00:00:00'],
                    ['created_at', '<=', date('Y-m-d') . ' 23:59:59']
                ])->count(),
                'products' => $rProduct->findAll()->count(),
                'products_today' => $rProduct->findBy([
                    ['created_at', '>=', date('Y-m-d') . ' 00:00:00'],
                    ['created_at', '<=', date('Y-m-d') . ' 23:59:59']
                ])->count(),
                'sells' => $rSell->findAll()->count(),
                'sells_today' => $rSell->findBy([
                    ['created_at', '>=', date('Y-m-d') . ' 00:00:00'],
                    ['created_at', '<=', date('Y-m-d') . ' 23:59:59']
                ])->count()
            ]
        ];

    }

}
