<?php

namespace App\Repositories\Eloquent\Dashboard;

use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Contracts\Dashboard\DashboardClientRepositoryInterface;
use App\Models\Dashboard\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DashboardClientRepository extends AbstractRepository implements DashboardClientRepositoryInterface {

    protected mixed $model = Client::class;

    public function validateForm(array $data) {
        $validate = Validator::make($data, [
            "name" => ["required", "string"],
            "email" => ["required", "email"],
            "type" => ["required", "integer", "min:1", "max:2"],
            "identification" => ["required", "string", Rule::unique('clients')->ignore($data['id'] ?? null)],
            "tel" => ["required", "integer"],
            "locations" => ["nullable"],
        ]);

        return $validate;
    }

}
