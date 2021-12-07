<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class DeliveryTime extends Model
{
    protected $fillable = [
        'minimum_time',
        'company_id',
        'maximum_time',
    ];
}
