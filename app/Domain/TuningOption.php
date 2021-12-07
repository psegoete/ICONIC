<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;
use CreatyDev\Domain\tuningType;

class TuningOption extends Model
{
    protected $fillable = [
        'credits',
        'label',
        'tooltip',
        'tuning_type_id',
        'company_id'
    ];

    public function tuning_type()
    {
        return $this->belongsTo(tuningType::class);
    }
    
}
