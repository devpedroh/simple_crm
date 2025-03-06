<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class SellsProduct extends Model {

    protected $fillable = [
        'sell_id',
        'product_id',
        'supplier_id',
        'price',
        'qtd',
        'total_price'
    ];

    public function sell () {
        return $this->belongsTo(Sell::class);
    }

    public function product () {
        return $this->belongsTo(Product::class)->with('weightUnit');
    }

    public function supplier () {
        return $this->belongsTo(Supplier::class);
    }

}
