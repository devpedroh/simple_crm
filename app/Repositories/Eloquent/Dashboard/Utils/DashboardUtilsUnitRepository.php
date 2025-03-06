<?php

namespace App\Repositories\Eloquent\Dashboard\Utils;

use App\Repositories\Eloquent\AbstractRepository;
use App\Repositories\Contracts\Dashboard\Utils\DashboardUtilsUnitRepositoryInterface;
use App\Models\Dashboard\Utils\Unit;

class DashboardUtilsUnitRepository extends AbstractRepository implements DashboardUtilsUnitRepositoryInterface
{

    protected mixed $model = Unit::class;

}
