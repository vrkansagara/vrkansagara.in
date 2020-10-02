<?php

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        return ($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }
}

if (!function_exists('is_production_mode')) {

    /**
     *Display all errors when APPLICATION_ENV is development.
     * @return bool
     */
    function is_production_mode(): bool
    {
        $isProductionModeEnable = in_array(env('APP_ENV'), ['prod', 'production', 'staging']);
        if ($isProductionModeEnable) {
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
            ini_set('display_errors', '0');
            ini_set("display_startup_errors", '0');
            ini_set("log_errors", '1');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
            ini_set("display_startup_errors", '1');
            ini_set("log_errors", '1');
        }
        return $isProductionModeEnable;
    }
}

