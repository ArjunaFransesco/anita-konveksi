<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $bulan  = $request->query('bulan', now()->format('Y-m'));
        $tipe   = $request->query('tipe', '');

        [$year, $month] = explode('-', $bulan);

        $query = Pengeluaran::whereYear('tanggal', $year)
                            ->whereMonth('tanggal', $month);

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        $pengeluarans = $query->orderByDesc('tanggal')->orderByDesc('id')->get();
        $totalBulanIni = $pengeluarans->sum('jumlah');
        $tipeLabels    = Pengeluaran::$tipeLabels;

        return view('kasir.pengeluaran.index', compact(
            'pengeluarans', 'totalBulanIni', 'tipeLabels', 'bulan', 'tipe'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'tipe'        => 'required|in:' . implode(',', array_keys(Pengeluaran::$tipeLabels)),
            'keterangan'  => 'required|string|max:255',
            'jumlah'      => 'required|numeric|min:1',
            'metode'      => 'required|in:tunai,transfer',
            'catatan'     => 'nullable|string|max:500',
            'foto_nota'   => 'nullable|array',
            'foto_nota.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'tanggal', 'tipe', 'keterangan', 'jumlah', 'metode', 'catatan'
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto_nota')) {
            $files = is_array($request->file('foto_nota')) ? $request->file('foto_nota') : [$request->file('foto_nota')];
            foreach ($files as $file) {
                $fotoPaths[] = $file->store('pengeluaran_nota', 'public');
            }
        }
        
        $data['foto_nota'] = empty($fotoPaths) ? null : json_encode($fotoPaths);

        Pengeluaran::create($data);

        return redirect()->route('owner.pengeluaran.index', [
            'bulan' => date('Y-m', strtotime($request->tanggal)),
        ])->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);
        
        if ($pengeluaran->foto_nota_array) {
            foreach ($pengeluaran->foto_nota_array as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }
        
        $pengeluaran->delete();
        return back()->with('success', 'Data pengeluaran berhasil dihapus.');
    }

    // ── Ekspor Excel (CSV) ────────────────────────────────────────────
    public function exportExcel(Request $request)
    {
        $bulan = $request->query('bulan', now()->format('Y-m'));
        $tipe  = $request->query('tipe', '');
        [$year, $month] = explode('-', $bulan);

        $query = Pengeluaran::whereYear('tanggal', $year)->whereMonth('tanggal', $month);
        if ($tipe) $query->where('tipe', $tipe);
        $rows  = $query->orderByDesc('tanggal')->get();

        $filename = 'pengeluaran_' . $bulan . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($rows) {
            $fp = fopen('php://output', 'w');
            // BOM agar Excel bisa baca UTF-8
            fputs($fp, "\xEF\xBB\xBF");
            fputcsv($fp, ['No', 'Tanggal', 'Tipe', 'Keterangan', 'Jumlah (Rp)', 'Metode', 'Catatan']);
            $no = 1;
            foreach ($rows as $r) {
                fputcsv($fp, [
                    $no++,
                    $r->tanggal->format('d/m/Y'),
                    $r->tipe_label,
                    $r->keterangan,
                    number_format($r->jumlah, 0, ',', '.'),
                    ucfirst($r->metode),
                    $r->catatan ?? '-',
                ]);
            }
            fclose($fp);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Ekspor PDF (DomPDF via Laravel) ──────────────────────────────
    public function exportPdf(Request $request)
    {
        $bulan = $request->query('bulan', now()->format('Y-m'));
        $tipe  = $request->query('tipe', '');
        [$year, $month] = explode('-', $bulan);

        $query = Pengeluaran::whereYear('tanggal', $year)->whereMonth('tanggal', $month);
        if ($tipe) $query->where('tipe', $tipe);
        $pengeluarans  = $query->orderByDesc('tanggal')->get();
        $totalBulanIni = $pengeluarans->sum('jumlah');
        $tipeLabels    = Pengeluaran::$tipeLabels;
        $judulBulan    = Carbon::createFromFormat('Y-m', $bulan)->isoFormat('MMMM YYYY');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('kasir.pengeluaran.pdf', compact(
            'pengeluarans', 'totalBulanIni', 'tipeLabels', 'judulBulan'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('pengeluaran_' . $bulan . '.pdf');
    }
}
