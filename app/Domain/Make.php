<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    protected $fillable = [
        'make_id',
        'name',
    ];
}
