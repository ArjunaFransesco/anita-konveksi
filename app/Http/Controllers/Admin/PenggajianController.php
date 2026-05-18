<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Penggajian;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PenggajianController extends Controller
{
    public function index(Request $request)
    {
        $bulan     = $request->query('bulan', now()->format('Y-m'));
        $minggu_ke = $request->query('minggu_ke', 1);
        $tipe      = $request->query('tipe', '');

        // 1. Ambil semua pegawai aktif
        $employeesQuery = Employee::where('is_active', true);
        if ($tipe) {
            $employeesQuery->where('employee_type', $tipe);
        }
        $employees = $employeesQuery->get();

        // 2. Generate penggajian 'pending' jika belum ada untuk periode ini
        foreach ($employees as $emp) {
            $existing = Penggajian::where('employee_id', $emp->id)
                ->where('bulan', $bulan)
                ->where('minggu_ke', $minggu_ke)
                ->first();

            if (!$existing) {
                // Default asumsi hari kerja
                // harian/mingguan = 6 hari, borongan = 1 (anggap per proyek/minggu)
                $hari_kerja = ($emp->employee_type === 'borongan') ? 1 : 6;
                $rate       = $emp->salary_rate ?? 0;
                $total      = $hari_kerja * $rate;

                Penggajian::create([
                    'employee_id' => $emp->id,
                    'bulan'       => $bulan,
                    'minggu_ke'   => $minggu_ke,
                    'hari_kerja'  => $hari_kerja,
                    'total_gaji'  => $total,
                    'status'      => 'pending',
                ]);
            }
        }

        // 3. Ambil data penggajian yang sesuai filter
        $penggajiansQuery = Penggajian::with('employee')
            ->where('bulan', $bulan)
            ->where('minggu_ke', $minggu_ke);

        if ($tipe) {
            $penggajiansQuery->whereHas('employee', function ($q) use ($tipe) {
                $q->where('employee_type', $tipe);
            });
        }

        $penggajians = $penggajiansQuery->get();

        // Statistik
        $totalPegawai      = $employees->count();
        $totalBulanIni     = Penggajian::where('bulan', $bulan)->where('status', 'dibayar')->sum('total_gaji');
        $belumDiproses     = $penggajians->where('status', 'pending')->count();

        return view('admin.penggajian.index', compact(
            'penggajians', 'bulan', 'minggu_ke', 'tipe', 
            'totalPegawai', 'totalBulanIni', 'belumDiproses'
        ));
    }

    public function proses(Request $request, $id)
    {
        $request->validate([
            'hari_kerja' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $penggajian = Penggajian::with('employee')->findOrFail($id);

                if ($penggajian->status === 'dibayar') {
                    throw new \Exception('Gaji ini sudah dibayar.');
                }

                $hari_kerja = $request->hari_kerja;
                $rate       = $penggajian->employee->salary_rate ?? 0;
                $total_gaji = $hari_kerja * $rate;

                // Update penggajian
                $penggajian->update([
                    'hari_kerja'    => $hari_kerja,
                    'total_gaji'    => $total_gaji,
                    'status'        => 'dibayar',
                    'tanggal_bayar' => now(),
                ]);

                // Otomatis catat di Pengeluaran
                Pengeluaran::create([
                    'tanggal'    => now(),
                    'tipe'       => 'gaji',
                    'keterangan' => 'Gaji ' . $penggajian->employee->name . ' (Minggu ke-' . $penggajian->minggu_ke . ' Bulan ' . $penggajian->bulan . ')',
                    'jumlah'     => $total_gaji,
                    'metode'     => 'tunai', // Default tunai
                    'catatan'    => 'Auto generated dari modul Penggajian',
                ]);
            });

            return back()->with('success', 'Gaji berhasil diproses dan dicatat di Pengeluaran.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cetak($id)
    {
        $penggajian = Penggajian::with('employee')->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.penggajian.slip_gaji_pdf', compact('penggajian'))
            ->setPaper('a5', 'landscape');

        return $pdf->download('Slip_Gaji_' . $penggajian->employee->name . '_M' . $penggajian->minggu_ke . '_' . $penggajian->bulan . '.pdf');
    }
}

