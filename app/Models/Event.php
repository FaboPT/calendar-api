<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';
    protected $dates = ['day_date', 'start_time', 'end_time'];
    protected $guarded = ['id'];

    /**
     * RELATIONSHIPS
     */

    public function ownerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

   public function eventUsers(): BelongsToMany
   {
       return $this->belongsToMany(User::class, 'events_users');
   }

    /**
     * SCOPES
     */

    public function scopeMyOwnerEvents($query, $user_id = null)
    {
        return $query->where('user_id', $user_id ?: Auth::user()->id);
    }
}
