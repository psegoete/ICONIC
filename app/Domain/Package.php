<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'package_name',
        'package_description',
        'price'
    ];
}
