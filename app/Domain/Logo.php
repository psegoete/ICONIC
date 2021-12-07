<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $fillable = [
        'make_id',
        'logo',
    ];
}
