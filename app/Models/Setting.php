<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::whereKey($key)->value('value') ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /** Last moment registration is open. */
    public static function registrationDeadline(): \Carbon\Carbon
    {
        return \Carbon\Carbon::parse(static::get('registration_deadline', '2000-01-01 00:00:00'));
    }

    public static function registrationOpen(): bool
    {
        return now()->lessThanOrEqualTo(static::registrationDeadline());
    }
}
