<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'status',
        'credits',
        'description',
        'company_id',
        'user_id',
    ];
}
