<?php

namespace App\Repositories\Eloquent\Dashboard;

use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Contracts\Dashboard\DashboardProductRepositoryInterface;
use App\Models\Dashboard\Product;
use Illuminate\Support\Facades\Validator;

class DashboardProductRepository extends AbstractRepository implements DashboardProductRepositoryInterface {

    protected mixed $model = Product::class;

    public function validateForm(array $data) {
        $validate = Validator::make($data, [
            "name" => ["required", "string"],
            "price" => ["nullable"],
            "weight" => ["nullable"],
            "weight_unit_id" => ["sometimes", "exists:measurement_units,id", "nullable"],
            "width" => ["nullable"],
            "width_unit_id" => ["sometimes", "exists:measurement_units,id", "nullable"],
            "length" => ["nullable"],
            "length_unit_id" => ["sometimes", "exists:measurement_units,id", "nullable"],
            "description" => ["nullable"]
        ]);

        return $validate;
    }

}
