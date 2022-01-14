<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class FileService extends Model
{
    protected $fillable = [
        'make',
        'model',
        'generation',
        'engine',
        'ecu',
        'engine_hp',
        'engine_kw',
        'year',
        'gearbox',
        'license_plate',
        'vin',
        'fuel_octane_rating',
        'read_method',
        'tuning_type',
        'tuning_options',
        'file_to_modify',
        'timeframe',
        'dyno',
        'info',
        'company_id',
        'user_id',
        'dynograph',
        'dynograph_title',
        'modified',
        'modified_title',
        'credits',
        'status',
        'file_to_modify_title',
        'notes',
        'downloaded_file_service',
        'note_to_customer',
        'viewed_by_customer',
    ];
}
