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
        return match ($this->value) {
            self::FO => "Fungsi Organisasi",
            self::OPD => "Organisasi Perangkat Daerah",
            self::BO => "Bendahara Organisasi",
            self::JF => "Jabatan Fungsional",
            self::PENANDATANGAN => "Penandatangan",
        };
    }
}
