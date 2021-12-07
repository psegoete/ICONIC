<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'monday',
        'monday_opening_time',
        'monday_closing_time',
        'monday_status',
        'tuesday',
        'tuesday_opening_time',
        'tuesday_closing_time',
        'tuesday_status',
        'wednesday',
        'wednesday_opening_time',
        'wednesday_closing_time',
        'wednesday_status',
        'thursday',
        'thursday_opening_time',
        'thursday_closing_time',
        'thursday_status',
        'friday',
        'friday_opening_time',
        'friday_closing_time',
        'friday_status',
        'saturday',
        'saturday_opening_time',
        'saturday_closing_time',
        'saturday_status',
        'sunday',
        'sunday_opening_time',
        'sunday_closing_time',
        'sunday_status',
        'holiday',
        'holiday_opening_time',
        'holiday_closing_time',
        'holiday_status',
        'company_id'
    ];
}
