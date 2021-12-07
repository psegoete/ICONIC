<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class UserTuningCredit extends Model
{
    protected $fillable = [
        'user_id',
        'credits',
        'company_id'
    ];
}
