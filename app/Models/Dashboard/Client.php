<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

    protected $fillable = [
        'name',
        'email',
        'type',
        'identification',
        'tel',
    ];

    public function locations () {
        return $this->hasMany(ClientsLocation::class);
    }

}
