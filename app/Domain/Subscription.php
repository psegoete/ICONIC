<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'starts_at',
        'ends_at',
        'status',
        'subscription_ammount'
    ];
}
