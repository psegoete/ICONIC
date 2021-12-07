<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class FileShareCredit extends Model
{
    protected $fillable = [
        'credits',
        'company_id',
        'user_id',
    ];
}
