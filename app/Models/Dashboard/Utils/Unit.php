<?php

namespace App\Models\Dashboard\Utils;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

    use HasFactory;

    protected $table = 'measurement_units';

    protected $fillable = [
        'name',
        'short_form',
    ];

}
