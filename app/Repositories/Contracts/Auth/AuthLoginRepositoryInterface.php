<?php

namespace App\Repositories\Contracts\Auth;

interface AuthLoginRepositoryInterface {

    public function verifyForm (array $data);

}
