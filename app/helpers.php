<?php

if (!function_exists('getSettings')) {
    function getSettings($key = null, $id = null)
    {
        // Return a dummy object to prevent errors in views
        return (object) [
            'logo' => asset('assets/images/light-logo.png'),
            'site_name' => 'Herozi',
            'favicon' => asset('assets/images/light-logo.png'),
        ];
    }
}
