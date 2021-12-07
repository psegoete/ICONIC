<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class MailHistory extends Model
{
    protected $fillable = [
        'seen',
        'from',
        'user_id',
        'file_service_id',
        'ticket_id',
        'comment_id',
        'subject',
        'email_type',
        'sent',
        'amount',
        'token',
        'company_id',
        'token',
    ];
}
