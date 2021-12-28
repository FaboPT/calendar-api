<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $guard_name = 'api';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * RELATIONSHIPS
     */

    public function userEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'events_users');
    }

    public function availability(): HasMany
    {
        return $this->HasMany(Availability::class, 'user_id', 'id');
    }

    public function ownerEvent(): HasMany
    {
        return $this->hasMany(Event::class, 'user_id', 'id');
    }

    /**
     * SCOPES
     */

    public function scopeMyOwnerEvents($query)
    {
        return $query->where('user_id', Auth::user()->getAuthIdentifier());
    }

    public function scopeMyEvents($query)
    {
        return $query->has('events', function ($q) {
            $q->where('user_id', Auth::user()->getAuthIdentifier());
        });
    }
}
