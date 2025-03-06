<?php

namespace App\Repositories\Eloquent\Dashboard\Utils;

use App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsPaymentMethodRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;
use App\Models\Dashboard\Utils\PaymentMethod;

class DashboardUtilsPaymentMethodRepository extends AbstractRepository implements DashboardUtilsPaymentMethodRepositoryInterface
{

    protected mixed $model = PaymentMethod::class;

}
