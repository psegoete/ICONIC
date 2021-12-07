<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class CredittierAmount extends Model
{
    protected $fillable = [
        'company_id',
        'amount',
    ];
}
