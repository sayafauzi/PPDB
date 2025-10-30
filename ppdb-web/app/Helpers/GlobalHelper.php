<?php

use Illuminate\Support\Str;

if (!function_exists('generateCustomId')) {
    /**
     * Generate custom ID unik untuk entitas tertentu.
     *
     * @param  string  $prefix  Prefix ID (misal: 'U', 'A', 'S')
     * @param  int  $randomLength  Jumlah karakter acak (default: 6)
     * @return string
     */
    function generateCustomIdUser(string $prefix = 'U', int $randomLength = 6): string
    {
        $datePart = now()->format('Ymd');
        $randPart = strtoupper(Str::random($randomLength));
        return "{$prefix}{$datePart}{$randPart}";
    }
}
