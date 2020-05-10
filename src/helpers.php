<?php

if (!function_exists('json_encode_prettify')) {
    /**
     * @param array $data
     * @return false|string
     */
    function json_encode_prettify(array $data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
