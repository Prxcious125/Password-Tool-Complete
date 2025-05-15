<?php

if (!function_exists('getFeedback')) {
    function getFeedback($strength, $default = '')
    {
        return match($strength) {
            'strong' => ['color' => 'bg-green-200 text-green-800'],
            'medium' => ['color' => 'bg-yellow-200 text-yellow-800'],
            'weak' => ['color' => 'bg-red-200 text-red-800'],
            default => ['color' => $default],
        };
    }
}
