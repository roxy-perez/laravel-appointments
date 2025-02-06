<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'slot_id',
        'user_id',
    ];

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function canBeCancelledByUser(User $user): bool
    {
        return $this->slot->slot_date->isFuture() && $this->isMyBooking($user);
    }

    public function isMyBooking(User $user): bool
    {
        return $this->user_id === $user->id;
    }
}
