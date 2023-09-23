<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function main(Request $req)
    {
        return view('dashboard.main');
    }
}
