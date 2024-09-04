<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Services\PermohonanService;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.public.dashboard.index');
    }
}
