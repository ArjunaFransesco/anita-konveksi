<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function transaksi()
    {
        return view('owner.transaksi');
    }

    public function laporan()
    {
        return view('owner.laporan');
    }

    public function piutang()
    {
        return view('owner.piutang');
    }

    public function monitoringProduksi()
    {
        return view('owner.monitoring');
    }
}
