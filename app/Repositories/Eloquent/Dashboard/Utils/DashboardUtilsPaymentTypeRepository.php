<?php

namespace App\Repositories\Eloquent\Dashboard\Utils;

use App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsPaymentTypeRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;
use App\Models\Dashboard\Utils\PaymentType;

class DashboardUtilsPaymentTypeRepository extends AbstractRepository implements DashboardUtilsPaymentTypeRepositoryInterface
{

    protected mixed $model = PaymentType::class;

}
