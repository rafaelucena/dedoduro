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

if (! function_exists('storage_put')) {
    /**
     * @param string $string
     * @param $file
     * @return mixed
     */
    function storage_put(string $string, $file) {
        // ...

        return Storage::putFile($string, $file);
    }
}

if (! function_exists('storage_del')) {
    /**
     * @param string $string
     * @return string
     */
    function storage_del(string $string) {
        // ...

        return Storage::delete($string);
    }
}
