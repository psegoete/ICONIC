<?php

namespace CreatyDev\Domain;

use Illuminate\Database\Eloquent\Model;
use CreatyDev\Domain\TuningOption;
use CreatyDev\Domain\Company\Models\Company;

class tuningType extends Model
{
    protected $fillable = [
        'credits',
        'label',
        'company_id'
    ];



    public function tuning_options()
    {
        return $this->hasMany(TuningOption::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
