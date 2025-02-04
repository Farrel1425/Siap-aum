<?php

namespace App\Http\Controllers;

use App\Models\OtpFailed;
use Illuminate\Http\Request;

class LogSistemController extends Controller
{
    public function otpGagalIndex()
    {
        $otp_faileds = OtpFailed::all();
        return view('pages.admin.log-sistem.otp-gagal.index', compact(
            'otp_faileds'
        ));
    }
}
