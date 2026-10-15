<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['name', 'is_registration'];

    protected $casts = ['is_registration' => 'boolean'];

    /** Batch names for dropdowns. */
    public static function names(): array
    {
        return static::orderBy('name')->pluck('name')->all();
    }

    /** Name of the batch new registrations are assigned to. */
    public static function registrationName(): string
    {
        return static::where('is_registration', true)->value('name') ?? 'Batch-01';
    }
}
