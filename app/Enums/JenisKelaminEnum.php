<?php

namespace App\Enums;

enum JenisKelaminEnum: int
{
    case LAKI_LAKI = 1;
    case PEREMPUAN = 0;

    public static function deskripsi(int $value): string
    {
        return match ($value) {
            self::LAKI_LAKI => 'Laki-laki',
            self::PEREMPUAN => 'Perempuan',
            default => 'Tidak diketahui',
        };
    }
}
