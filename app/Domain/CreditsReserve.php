<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class CreditsReserve extends Model
{
    protected $fillable = [
        'credits',
        'company_id',
        'status',
        'action',
        'token',
        'description',
        'user_id',
        'amount',
    ];
}
