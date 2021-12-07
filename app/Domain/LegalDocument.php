<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $fillable = [
        'privancy_policy',
        'refund_policy',
        'terms_and_conditions',
        'disclaimer',
        'company_id'
    ];
}
