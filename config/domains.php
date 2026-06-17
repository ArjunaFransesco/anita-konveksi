<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pemisahan domain publik dan domain staf
    |--------------------------------------------------------------------------
    |
    | Biarkan "enabled" bernilai false saat pengembangan lokal agar landing
    | page tetap dapat dibuka di / dan login staf tetap tersedia di /login.
    | Aktifkan di hosting setelah PUBLIC_DOMAIN dan STAFF_DOMAIN diisi.
    |
    */
    'enabled' => filter_var(env('DOMAIN_ROUTING_ENABLED', false), FILTER_VALIDATE_BOOL),

    // Tulis nama host saja, tanpa https:// dan tanpa garis miring di belakang.
    'public' => env('PUBLIC_DOMAIN'),
    'staff' => env('STAFF_DOMAIN'),
];
