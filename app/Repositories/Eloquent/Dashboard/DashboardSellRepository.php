<?php

namespace App\Repositories\Eloquent\Dashboard;

use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Contracts\Dashboard\DashboardSellRepositoryInterface;
use App\Models\Dashboard\Sell;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DashboardSellRepository extends AbstractRepository implements DashboardSellRepositoryInterface {

    protected mixed $model = Sell::class;

    public function validateForm(array $data) {
        $validate = Validator::make($data, [
            "client_id" => ["required", "numeric", "exists:clients,id"],
            "total_price" => ["nullable"],
            "payment_method_id" => ["required", "numeric", "exists:payment_methods,id"],
            "payment_type_id" => ["required", "numeric", "exists:payment_types,id"],
            "description" => ["nullable"],
            "products" => ["nullable"],
        ]);

        return $validate;
    }

}
