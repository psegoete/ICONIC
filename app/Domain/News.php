<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'display_date',
        'contents',
        'visibility',
        'company_id'
    ];
}
