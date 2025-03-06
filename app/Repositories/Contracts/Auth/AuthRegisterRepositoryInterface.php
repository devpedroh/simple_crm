<?php

namespace App\Repositories\Contracts\Auth;

interface AuthRegisterRepositoryInterface {

    public function validateForm (array $data);

}
