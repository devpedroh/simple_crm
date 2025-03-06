<?php

namespace App\Models\Dashboard\Utils;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'short_form',
    ];

}
