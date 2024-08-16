<?php

// Cek apakah fungsi belum ada untuk menghindari konflik
if (!function_exists('dynamic_asset')) {
    function dynamic_asset($path) {
        $baseUrl = config('app.url');

        // Cek apakah menggunakan `php artisan serve`
        if (app()->runningInConsole()) {
            return $baseUrl . '/' . ltrim($path, '/');
        }

        // Untuk mode manual `localhost`
        return $baseUrl . '/' . ltrim($path, '/');
    }
}
