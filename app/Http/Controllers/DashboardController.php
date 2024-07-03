<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->is_admin){
            return view('pages.admin.dashboard.index');
        }else if (auth()->user()->is_public){
            return view('pages.public.dashboard.index');
        }else{
            abort(401);
        }
    }
}
