<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use Illuminate\Support\Facades\DB;

class AppController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function about()
    {
        return view('about');
    }

    public function service()
    {
        return view('service');
    }
}
