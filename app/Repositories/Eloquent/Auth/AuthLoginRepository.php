<?php

namespace App\Repositories\Eloquent\Auth;

use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Contracts\Auth\AuthLoginRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthLoginRepository extends AbstractRepository implements AuthLoginRepositoryInterface {

    protected mixed $model = User::class;

    public function verifyForm(array $data): bool {
        $validate = Validator::make($data, [
            "email" => ["required"],
            "password" => ["required"],
        ]);

        return $validate->fails();
    }

}
