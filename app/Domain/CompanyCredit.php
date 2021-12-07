<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class CompanyCredit extends Model
{
    protected $fillable = [
        'description',
        'from',
        'for'
    ];
}
