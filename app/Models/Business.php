<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'image',
        'max_future_days',
        'slot_duration',
    ];

    public function casts(): array
    {
        return [
            'name' => 'string',
            'phone' => 'string',
            'address' => 'string',
            'image' => 'string',
            'max_future_days' => 'int',
            'slot_duration' => 'int',
        ];
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function slots(): HasMany
    {
        return $this->hasMany(Slot::class);
    }
}
