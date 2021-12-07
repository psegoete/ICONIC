<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class TuningCredit extends Model
{
    protected $fillable = [
        'description',
        'from',
        'for',
        'company_id'
    ];
}
