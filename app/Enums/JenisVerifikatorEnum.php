<?php

namespace App\Enums;

enum JenisVerifikatorEnum: string
{
    case FO = "0";
    case OPD = "1";
    case BO = "2";
    case JF = "3";
    case PENANDATANGAN = "4";

    public function deskripsi(): string
    {
        return match ($this) {
            self::FO => "Verifikator FO",
            self::OPD => "Verifikator OPD",
            self::BO => "Verifikator BO",
            self::JF => "Vefikator JF",
            self::PENANDATANGAN => "Penandatangan",
        };
    }
}
