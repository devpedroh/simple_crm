<?php

namespace App\Repositories\Eloquent\Dashboard;

use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Contracts\Dashboard\DashboardSupplierRepositoryInterface;
use App\Models\Dashboard\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DashboardSupplierRepository extends AbstractRepository implements DashboardSupplierRepositoryInterface {

    protected mixed $model = Supplier::class;

    public function validateForm(array $data) {
        $validate = Validator::make($data, [
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "type" => ["required", "integer", "min:1", "max:2"],
            "identification" => ["required", "string", Rule::unique('suppliers')->ignore($data['id'] ?? null)],
            "tel" => ["required", "integer"],
            "locations" => ["nullable"],
        ]);

        return $validate;
    }

}
