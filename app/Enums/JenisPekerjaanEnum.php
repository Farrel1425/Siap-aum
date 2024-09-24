<?php

namespace App\Enums;
use App\Traits\EnumToArray;

enum JenisPekerjaanEnum: string
{
    use EnumToArray;
    case PNS = 'PNS';
    case TNI = 'TNI';
    case POLRI = 'POLRI';
    case SWASTA = 'Swasta';
    case WIRASWASTA = 'Wiraswasta';
    case LAINNYA = 'Lain-lain';

    public function deskripsi(): string
    {
        return match ($this) {
            self::PNS => 'PNS',
            self::TNI => 'TNI',
            self::POLRI => 'POLRI',
            self::SWASTA => 'Karyawan Swasta',
            self::WIRASWASTA => 'Wiraswasta',
            self::LAINNYA => 'Lain-lain',
        };
    }
}
