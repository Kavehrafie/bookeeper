<?php
if (!function_exists('getCitiesJSON')) {
    function getCitiesJSON()
    {
        return array_map( fn($e) => $e['name'],json_decode(
            file_get_contents(config('settings.cities_path'))
            , true));
    }
}
