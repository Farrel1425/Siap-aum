<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->is_admin) {
            return view('pages.admin.dashboard.index');
        } else if (auth()->user()->is_public) {
            $dashboardUserController = new DashboardUserController();
            return $dashboardUserController->index($request);
        } else if (auth()->user()->is_verifikator) {
            return view('pages.verifikator.dashboard.index');
        } else {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses, silahkan login kembali');
        }
    }
}
