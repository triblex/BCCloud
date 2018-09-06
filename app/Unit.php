<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'unit_name', 'description'
    ];

    /*
    public function unit_data()
    {
        return $this->hasMany(Unit_data::class);
    }
    */
}
