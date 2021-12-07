<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $fillable = [
        'device_id',
        'user_id',
        'company_id'
    ];
}
