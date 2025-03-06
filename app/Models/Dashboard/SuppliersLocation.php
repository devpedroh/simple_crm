<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class SuppliersLocation extends Model {

    protected $fillable = [
        'client_id',
        'street',
        'number',
        'complement',
        'city',
        'state',
        'country',
    ];

    public function supplier () {
        return $this->belongsTo(Supplier::class);
    }

}
