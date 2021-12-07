<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    protected $fillable = [
        'generation_id',
        'engine_id',
        'code',
        'name',
        'fuel_type',
        'power',
        'torque',
        'flag',
    ];
}
