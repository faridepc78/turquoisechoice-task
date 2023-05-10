<?php

if (!function_exists('filterNullData')) {
    function filterNullData($values): array
    {
        return array_filter($values, function ($value) {
            return $value !== null && $value !== false && $value !== '';
        });
    }
}
