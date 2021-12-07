<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;

class PlatformSetting extends Model
{
    protected $fillable = [
        'starter_credits',
        'zip_file_service_files',
        'original_zip_files_for_tuners',
        'evc_enabled',
        'notes_to_customers',
        'company_id'
    ];
}
