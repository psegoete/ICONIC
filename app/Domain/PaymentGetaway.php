<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class PaymentGetaway extends Model
{
    protected $fillable = [
        'payment_name',
        'payment_provider',
        'instructions',
        'merchant_id',
        'merchant_key',
        'company_id',
        'companyid',
    ];
}
