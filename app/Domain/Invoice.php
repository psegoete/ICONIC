<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no',
        'description',
        'amount',
        'user_id',
        'company_id'
    ];
}
