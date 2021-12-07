<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class PassworRecover extends Model
{
    protected $fillable = [
        'status',
        'user_id',
        'company_id',
        'token',
    ];
}
