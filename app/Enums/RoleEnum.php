<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'Admin';
    case PUBLIC = 'Public';
    case VERIFIKATOR = 'Verifikator';
    case AUDITOR = 'Auditor';
    case INPUTER = 'Inputer';
}
