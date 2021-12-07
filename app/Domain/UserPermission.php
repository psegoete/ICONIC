<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = [
        'user_id',
        'permission_id',
        'company_id'
    ];
}
