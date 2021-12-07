<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class ReadMethod extends Model
{
    //
    protected $fillable = [
        'read_method_name',
        'company_id'
    ];
}

