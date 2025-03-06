<?php

namespace App\Models\Dashboard;

use App\Models\Dashboard\Utils\Unit;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name',
        'price',
        'weight',
        'weight_unit_id',
        'width',
        'width_unit_id',
        'length',
        'length_unit_id',
        'description'
    ];

    public function weightUnit () {
        return $this->belongsTo(Unit::class, 'weight_unit_id');
    }

    public function widthUnit () {
        return $this->belongsTo(Unit::class, 'width_unit_id');
    }

    public function lengthUnit () {
        return $this->belongsTo(Unit::class, 'length_unit_id');
    }

    public function sell () {

        $this->belongsTo(Sell::class);

    }

    public function stock () {

        $this->belongsTo(Stock::class);

    }

}
