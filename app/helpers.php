<?php

if (! function_exists('option')) {
    /**
     * Get / set the specified option value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed|\App\Models\Option
     */
    function option($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('option');
        }

        if (is_array($key)) {
            return app('option')->set($key);
        }

        return app('option')->get($key, $default);
    }
}
if (! function_exists('money')) {
    /**
     * An amount in Australian dollars for display, e.g. $1,234.50. The shop
     * only sells in AUD (Order::CURRENCY).
     *
     * @param  int|float|string|null  $dollars
     */
    function money($dollars): string
    {
        // Amounts formatted elsewhere may contain thousands separators
        return '$' . number_format((float) str_replace(',', '', (string) $dollars), 2);
    }
}
