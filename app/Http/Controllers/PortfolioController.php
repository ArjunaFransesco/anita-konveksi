<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'semua');
        return view('portfolio', compact('kategori'));
    }
}