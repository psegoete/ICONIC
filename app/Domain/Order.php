<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_no',
        'description',
        'amount',
        'status',
        'user_id',
        'company_id',
        'order_reference',
        'invoice_id'
    ];
}
