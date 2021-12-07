<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class CreditGroup extends Model
{
    protected $fillable = [
        'name',
        'default',
        'company_id',
    ];
}
