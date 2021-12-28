<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Availability extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'availabilities';
    protected $dates = ['end_date', 'start_time', 'end_time'];
    protected $guarded = ['id'];

    /**
     * RELATIONSHIPS
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * SCOPES
     */

    public function scopeMyAvailabilities($query, $user_id = null)
    {
        return $query->where('user_id', $user_id ?: Auth::user()->getAuthIdentifier());
    }
}
