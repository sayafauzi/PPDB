<?php

namespace App\Helpers;

class IdGenerator
{
    public static function generateAkunId(string $prefix = 'A'): string
    {
        $datePart = now()->format('Ymd');
        $randPart = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        return "{$prefix}{$datePart}{$randPart}";
    }
}
