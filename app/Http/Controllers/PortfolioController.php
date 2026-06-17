<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Katalog;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'semua');
        
        if ($kategori != 'semua') {
            $katalogs = Katalog::where('kategori', $kategori)->get();
        } else {
            $katalogs = Katalog::latest()->get();
        }
        
        return view('portfolio', compact('kategori', 'katalogs'));
    }
}