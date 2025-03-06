<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{

    protected $fillable = [
        'client_id',
        'payment_method_id',
        'payment_type_id',
        'total_price',
        'description',
    ];

    public function client () {

        return $this->belongsTo(Client::class);

    }

    public function products () {

        return $this->hasMany(SellsProduct::class)->with(['product', 'supplier']);

    }

}
