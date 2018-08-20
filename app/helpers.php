<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('strslug')) {
    /**
     * @param string $string
     * @return string
     */
    function strslug(string $string) {
        // ...
        return Str::slug($string);
    }
}