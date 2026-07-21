<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class venderController extends Controller
{
    public function index()
    {
        return view('vender-invoice.index');
    }

    public function addVenderInvoice()
    {
        return view('vender-invoice.add');
    }
}

