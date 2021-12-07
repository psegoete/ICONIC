<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class carModel extends Model
{
    protected $fillable = [
        'make_id',
        'model_id',
        'name',
    ];
}
