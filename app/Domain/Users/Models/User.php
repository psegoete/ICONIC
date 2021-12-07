<?php

namespace CreatyDev\Domain\Users\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;
use Laravel\Passport\HasApiTokens;
use CreatyDev\App\Traits\Eloquent\Auth\HasConfirmationToken;
use CreatyDev\App\Traits\Eloquent\Auth\HasTwoFactorAuthentication;
use CreatyDev\App\Traits\Eloquent\Roles\HasPermissions;
use CreatyDev\App\Traits\Eloquent\Roles\HasRoles;
use CreatyDev\App\Traits\Eloquent\Subscriptions\HasSubscriptions;
use CreatyDev\Domain\Company\Models\Company;
use CreatyDev\Domain\Subscriptions\Models\Plan;
use CreatyDev\Domain\Teams\Models\Team;
use CreatyDev\Domain\Ticket\Models\Ticket;
use CreatyDev\Domain\Ticket\Models\Comment;
use CreatyDev\Domain\Users\Filters\UserFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use IlluminateAgnostic\Collection\Contracts\Support\Jsonable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,
        HasConfirmationToken,
        HasRoles,
        HasPermissions,
        Billable,
        HasSubscriptions,
        SoftDeletes,
        HasTwoFactorAuthentication,
        HasApiTokens;

    /**
     * The attributes that should be appended to the model.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'password',
        'account_type',
        'address1',
        'address2',
        'city',
        'zipcode',
        'activated',
        'profile_image',
        'company_id',
        'role',
        'title',
        'country',
        'province',
        'business_name',
        'vat_number',
        'credit_group_id',
        'ticket_display_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Filters the result.
     *
     * @param Builder $builder
     * @param $request
     * @param array $filters
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new UserFilters($request))->add($filters)->filter($builder);
    }

    /**
     * Get user's full name as attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }
    public function profile_image()
    {
        return $this->profile_image;
    }

    /**
     * Check if user is activated.
     *
     * @return mixed
     */
    public function hasActivated()
    {
        return $this->activated;
    }

    /**
     * Check if user is not activated.
     *
     * @return bool
     */
    public function hasNotActivated()
    {
        return !$this->hasActivated();
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user's team limit reached.
     *
     * @return bool
     */
    public function teamLimitReached()
    {
        return $this->team->users->count() === $this->plan->teams_limit;
    }

    /**
     * Check if current user matches passed user.
     *
     * @param User $user
     * @return bool
     */
    public function isTheSameAs(User $user)
    {
        return $this->id === $user->id;
    }

    /**
     * Get team owned by user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function team()
    {
        return $this->hasOne(Team::class);
    }

    /**
     * Get plan that the user is currently on.
     *
     * @return mixed
     */
    public function plan()
    {
        return $this->plans->first();
    }

    /**
     * Get user's plan as a property.
     *
     * @return mixed
     */
    public function getPlanAttribute()
    {
        return $this->plan();
    }

    /**
     * Get plans owned by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function plans()
    {
        return $this->hasManyThrough(
            Plan::class,
            Subscription::class,
            'user_id',
            'gateway_id',
            'id',
            'stripe_plan'
        )->orderBy('subscriptions.created_at', 'desc');
    }

    /**
     * Get teams that user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_users');
    }

    /**
     * Get user's last accessed company.
     *
     * If using the new tenant switch functionality:
     * Append 'lastAccessedCompany' to model 'appends' property
     * And uncomment lines below
     *
     * @return mixed
     */
    // public function getLastAccessedCompanyAttribute()
    // {
    //    return $this->companies()->orderByDesc('last_login_at')->first();
    // }

    /**
     * Get companies that user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_users');
    }

    // user profile image
    public function getImageAttribute()
    {
        return $this->profile_image;
    }

    // Ticket system
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    // end ticket system

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
