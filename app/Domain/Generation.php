<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'model_id',
        'generation_id',
        'name',
        'long_name',
        'start_year',
        'start_month',
        'end_month',
        'end_year',
    ];}
