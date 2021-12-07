<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Credittier extends Model
{
    protected $fillable = [
        'from',
        'for',
        'credit_group_id',
        'credittier_amounts_id',
        'company_id',
    ];
}
