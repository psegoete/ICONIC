<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //
    protected $fillable = [
        'message',
        'filename'
    ];
}
