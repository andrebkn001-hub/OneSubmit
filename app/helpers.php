<?php

if (!function_exists('join_paths')) {
    function join_paths(...$segments)
    {
        $paths = array_filter($segments, fn ($p) => $p !== '' && $p !== null);
        return preg_replace('#/+#', '/', join(DIRECTORY_SEPARATOR, $paths));
    }
}
