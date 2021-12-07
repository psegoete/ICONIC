<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $fillable = [
        'name',
        'action',
        'subject',
        'body',
        'company_id',
    ];
}
