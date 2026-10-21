<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Key/value settings stored in the `options` table.
 *
 * Replaces the abandoned appstract/laravel-options package. Use the
 * option() helper in app/helpers.php to read and write values.
 */
class Option extends Model
{
    public $timestamps = false;

    protected $casts = [
        'value' => 'json',
    ];

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Determine if the given option value exists.
     */
    public function exists($key)
    {
        return self::where('key', $key)->exists();
    }

    /**
     * Get the specified option value.
     */
    public function get($key, $default = null)
    {
        if ($option = self::where('key', $key)->first()) {
            return $option->value;
        }

        return $default;
    }

    /**
     * Set a given option value.
     *
     * @param  array|string  $key
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            self::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    /**
     * Remove/delete the specified option value.
     */
    public function remove($key)
    {
        return (bool) self::where('key', $key)->delete();
    }
}
