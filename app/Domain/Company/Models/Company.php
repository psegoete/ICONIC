<?php

namespace CreatyDev\Domain\Company\Models;

use Illuminate\Database\Eloquent\Model;
use CreatyDev\App\Tenant\Traits\IsTenant;
use CreatyDev\Domain\Project\Models\Project;
use CreatyDev\Domain\tuningType;
use CreatyDev\Domain\Gearboxe;
use CreatyDev\Domain\ReadMethod;

class Company extends Model
{
    //use IsTenant;

    protected $fillable = [
        'company_name',
        'address1',
        'address2',
        'zipcode',
        'city',
        'domain_name',
        'country',
        'company_email',
        'company_phone',
        'uuid',
        'province',
        'phone_number',
        'bank_account',
        'bank_identification_code',
        'chamber_of_commernce_number',
        'tax_identifier',
        'skype_username',
        'facebook',
        'twitter',
        'google',
        'linkedIn',
        'youtube',
        'instagram',
        'pinterest',
        'wechat',
        'qq',
        'website',
        'google_tag_manager_code',
        'google_analytics_code',
        'company_logo',
        'active',
        'blocked',
        'plan',
    ];

    /**
     * Get projects owned by company.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function tuning_types()
    {
        return $this->hasMany(tuningType::class);
    }

    public function gearboxes()
    {
        return $this->hasMany(Gearboxe::class);
    }

    public function read_methods()
    {
        return $this->hasMany(ReadMethod::class);
    }
}
