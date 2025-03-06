<?php

namespace App\Repositories\Eloquent\Auth;

use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Contracts\Auth\AuthRegisterRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthRegisterRepository extends AbstractRepository implements AuthRegisterRepositoryInterface {

    protected mixed $model = User::class;

    public function validateForm(array $data): bool {
        $validate = Validator::make($data, [
            "name" => ["required", "min:5"],
            "email" => ["required", "unique:users"],
            "password" => ["required", "min:6"],
        ]);

        return $validate->fails();
    }

}
