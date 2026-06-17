<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHasilFoto;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Size;
use App\Models\OrderDetailLogo;

class KasirController extends Controller
{
    // ─────────────────────────────────────────────
    //  INPUT PESANAN
    // ─────────────────────────────────────────────

    /** GET: tampil form input pesanan */
    public function inputPesanan()
    {
        $sizes = Size::all(); // untuk dropdown ukuran standar
        return view('kasir.input_pesanan', compact('sizes'));
    }

    /** POST: simpan pesanan baru */
    public function storePesanan(Request $request)
    {
        $request->validate([
            'nama'              => 'required|string|max:100',
            'no_hp'             => 'nullable|string|max:20',
            'alamat'            => 'nullable|string',
            'deadline'          => 'nullable|date',
            'tipe_pembayaran'   => 'required|in:lunas,dp',   // ← konsisten dengan blade
            'dp'                => 'nullable|numeric|min:0',
            'metode_dp'         => 'nullable|in:tunai,transfer',
            'jenis_produk'      => 'required|array|min:1',
            'jenis_produk.*'    => 'required|string|max:100',
            'jumlah.*'          => 'required|integer|min:1',
            'harga_satuan.*'    => 'required|numeric|min:0',
            'size_id.*'         => 'nullable|string', // bisa 'custom' atau id
            'size_custom.*'     => 'nullable|string|max:20',
            'logo'              => 'nullable|array',
            'logo.*'            => 'nullable|array',
            'logo.*.*'          => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'desain_detail'     => 'nullable|array',
            'desain_detail.*'   => 'nullable|array',
            'desain_detail.*.*' => 'nullable|string|max:255',
            'bukti_pembayaran'  => 'nullable|array',
            'bukti_pembayaran.*'=> 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Customer
            $customer = Customer::firstOrCreate(
                ['no_hp' => $request->no_hp ?? null],
                ['nama' => $request->nama, 'alamat' => $request->alamat]
            );
            $customer->update(['nama' => $request->nama, 'alamat' => $request->alamat]);

            // 2. Hitung total dan diskon
            $details = [];
            $totalRaw = 0;
            $totalQty = 0;

            foreach ($request->jenis_produk as $i => $jenis) {
                $qty = (int) $request->jumlah[$i];
                $harga = (float) $request->harga_satuan[$i];
                $subtotal = $qty * $harga;
                $totalRaw += $subtotal;
                $totalQty += $qty;

                // Upload beberapa logo/desain untuk produk ini.
                // Backward compatibility: logo pertama tetap disimpan ke kolom lama order_details.logo_path
                // dan keterangan pertama tetap disimpan ke kolom lama order_details.desain.
                $logoItems = [];
                $firstLogoPath = null;
                $firstDesain = $request->desain_detail[$i][0] ?? ($request->desain[$i] ?? null);

                if ($request->hasFile("logo.$i")) {
                    foreach ($request->file("logo.$i") as $logoIndex => $file) {
                        if (!$file) continue;

                        $path = $this->saveUploadedFileToPublic($file, 'order_logos');
                        if ($firstLogoPath === null) {
                            $firstLogoPath = $path;
                        }

                        $logoItems[] = [
                            'logo_path' => $path,
                            'keterangan_desain' => $request->desain_detail[$i][$logoIndex] ?? null,
                        ];
                    }
                }

                // Jika user menambah form desain/sablon tanpa file logo, tetap simpan keterangannya.
                foreach (($request->desain_detail[$i] ?? []) as $logoIndex => $ket) {
                    $ket = trim((string) $ket);
                    if ($ket === '') continue;

                    $alreadyExists = isset($logoItems[$logoIndex]);
                    if (!$alreadyExists) {
                        $logoItems[] = [
                            'logo_path' => null,
                            'keterangan_desain' => $ket,
                        ];
                    }
                }

                // Size logic: jika 'custom' maka simpan ke size_custom, else size_id
                $sizeId = null;
                $sizeCustom = null;
                if (!empty($request->size_id[$i])) {
                    if ($request->size_id[$i] === 'custom') {
                        $sizeCustom = $request->size_custom[$i] ?? null;
                    } else {
                        $sizeId = (int) $request->size_id[$i];
                    }
                }

                $details[] = [
                    'jenis_produk' => $jenis,
                    'jumlah'       => $qty,
                    'ukuran'       => $request->ukuran[$i] ?? null, // opsional backward
                    'bahan'        => $request->bahan[$i] ?? null,
                    'warna'        => $request->warna[$i] ?? null,
                    'desain'       => $firstDesain,
                    'harga_satuan' => $harga,
                    'subtotal'     => $subtotal,
                    'logo_path'    => $firstLogoPath,
                    'size_id'      => $sizeId,
                    'size_custom'  => $sizeCustom,
                    'logo_items'   => $logoItems,
                ];
            }

            // Diskon Manual
            $diskonJenis = $request->input('diskon_jenis', 'persen');
            $diskonValue = (float) $request->input('diskon_value', 0);

            $diskonPersen = 0;
            $diskonNominal = 0;

            if ($diskonValue > 0) {
                if ($diskonJenis === 'nominal') {
                    $diskonNominal = $diskonValue;
                    if ($totalRaw > 0) {
                        $diskonPersen = ($diskonNominal / $totalRaw) * 100;
                    }
                } else {
                    $diskonPersen = $diskonValue;
                    $diskonNominal = $totalRaw * ($diskonPersen / 100);
                }
            }

            // Batasi diskon tidak melebihi total
            if ($diskonNominal > $totalRaw) {
                $diskonNominal = $totalRaw;
                $diskonPersen = 100;
            }

            $totalSetelahDiskon = max(0, $totalRaw - $diskonNominal);

            // 3. Tentukan DP berdasarkan tipe_pembayaran
            $tipePembayaran = $request->tipe_pembayaran;
            if ($tipePembayaran === 'lunas') {
                $dp = $totalSetelahDiskon;
                $metodeDp = $request->metode_dp ?? 'tunai';
            } else { // dp
                $dp = (float) ($request->dp ?? 0);
                // Jika DP melebihi total setelah diskon, batasi
                if ($dp > $totalSetelahDiskon) $dp = $totalSetelahDiskon;
                $metodeDp = $request->metode_dp ?? 'tunai';
            }
            $sisaTagihan = max(0, $totalSetelahDiskon - $dp);
            $statusBayar = ($sisaTagihan <= 0) ? 'lunas' : 'belum';

            // 4. Simpan order
            $order = Order::create([
                'invoice_number'       => Order::generateInvoice(),
                'customer_id'          => $customer->id,
                'tanggal_pesan'        => now()->toDateString(),
                'deadline'             => $request->deadline,
                'total_harga'          => $totalRaw,
                'diskon_jenis'         => $diskonJenis,
                'diskon_tipe'          => ($diskonValue > 0) ? $diskonJenis : 'none',
                'diskon_persen'        => $diskonPersen,
                'diskon_nominal'       => $diskonNominal,
                'total_setelah_diskon' => $totalSetelahDiskon,
                'dp'                   => $dp,
                'sisa_tagihan'         => $sisaTagihan,
                'status_produksi'      => 'nunggu_konfirmasi',
                'status_pembayaran'    => $statusBayar,
            ]);

            // 5. Detail order
            foreach ($details as $d) {
                $logoItems = $d['logo_items'] ?? [];
                unset($d['logo_items']);

                $detail = $order->details()->create($d);

                foreach ($logoItems as $logoItem) {
                    $detail->logoItems()->create($logoItem);
                }
            }

            // 6. Catat pembayaran (jika ada DP atau lunas)
            if ($dp > 0) {
                $buktiPaths = [];
                if ($request->hasFile('bukti_pembayaran')) {
                    $files = is_array($request->file('bukti_pembayaran')) ? $request->file('bukti_pembayaran') : [$request->file('bukti_pembayaran')];
                    foreach ($files as $file) {
                        $buktiPaths[] = $this->saveUploadedFileToPublic($file, 'payment_proofs');
                    }
                }

                $order->payments()->create([
                    'tanggal_bayar'  => now()->toDateString(),
                    'jumlah'         => $dp,
                    'metode'         => $metodeDp,
                    'bukti_transfer' => empty($buktiPaths) ? null : json_encode($buktiPaths),
                    'tipe'           => ($tipePembayaran === 'lunas') ? 'pelunasan' : 'dp',
                    'catatan'        => $tipePembayaran === 'lunas' ? 'Lunas saat input pesanan' : 'DP awal',
                ]);
            }
        });

        return redirect()->route('owner.pesanan.index')
            ->with('success', 'Pesanan berhasil disimpan!');
    }

    // ─────────────────────────────────────────────
    //  DAFTAR & UPDATE PESANAN (STATUS)
    // ─────────────────────────────────────────────

    /** GET: daftar semua pesanan */
    public function daftarPesanan(Request $request)
    {
        $search = $request->query('q');

        $orders = Order::with('customer')
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_number', 'like', "%$search%")
                    ->orWhereHas('customer', fn($q) => $q->where('nama', 'like', "%$search%"));
            })
            ->orderByDesc('created_at')
            ->get();

        return view('kasir.update_status', compact('orders', 'search'));
    }

    /** Alias lama – masih dipakai di route GET /kasir/status/update */
    public function updateStatus()
    {
        return $this->daftarPesanan(request());
    }

    /** POST: update status produksi */
    public function updateStatusProduksi(Request $request, $id)
    {
        $request->validate([
            'status_produksi' => 'required|in:' . implode(',', array_keys(Order::$statusProduksiLabels)),
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status_produksi' => $request->status_produksi]);

        return redirect()->route('owner.pesanan.index')
            ->with('success', "Status pesanan {$order->invoice_number} berhasil diperbarui.");
    }

    // ─────────────────────────────────────────────
    //  CATAT PEMBAYARAN
    // ─────────────────────────────────────────────

    /** GET: form catat pembayaran */
    public function catatPembayaran(Request $request)
    {
        $orders = Order::with('customer')
            ->where('status_pembayaran', 'belum')
            ->orderByDesc('created_at')
            ->get();

        $selected = null;
        if ($request->has('order_id')) {
            $selected = Order::with(['customer', 'payments'])->find($request->order_id);
        }

        return view('kasir.catat_pembayaran', compact('orders', 'selected'));
    }

    /** POST: simpan pembayaran */
    public function storePembayaran(Request $request)
    {
        $request->validate([
            'order_id'      => 'required|exists:orders,id',
            'jumlah'        => 'required|numeric|min:1',
            'metode'        => 'required|in:tunai,transfer',
            'tipe'          => 'required|in:dp,pelunasan',
            'tanggal_bayar' => 'required|date',
            'catatan'       => 'nullable|string',
            'bukti_pembayaran' => 'nullable|array',
            'bukti_pembayaran.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::findOrFail($request->order_id);

            $buktiPaths = [];
            if ($request->hasFile('bukti_pembayaran')) {
                $files = is_array($request->file('bukti_pembayaran')) ? $request->file('bukti_pembayaran') : [$request->file('bukti_pembayaran')];
                foreach ($files as $file) {
                    $buktiPaths[] = $this->saveUploadedFileToPublic($file, 'payment_proofs');
                }
            }

            $order->payments()->create([
                'tanggal_bayar'  => $request->tanggal_bayar,
                'jumlah'         => $request->jumlah,
                'metode'         => $request->metode,
                'bukti_transfer' => empty($buktiPaths) ? null : json_encode($buktiPaths),
                'tipe'           => $request->tipe,
                'catatan'        => $request->catatan,
            ]);

            $totalBayar = $order->payments()->sum('jumlah');
            $sisa = $order->total_setelah_diskon - $totalBayar; // gunakan total setelah diskon
            $statusBayar = $sisa <= 0 ? 'lunas' : 'belum';

            $order->update([
                'dp'                => $order->payments()->where('tipe', 'dp')->sum('jumlah'),
                'sisa_tagihan'      => max(0, $sisa),
                'status_pembayaran' => $statusBayar,
            ]);
        });

        return redirect()->route('owner.pembayaran.catat')
            ->with('success', 'Pembayaran berhasil dicatat!');
    }

    /** AJAX: ambil detail order untuk dropdown */
    public function getOrderDetail($id)
    {
        $order = Order::with(['customer', 'payments'])->findOrFail($id);

        return response()->json([
            'invoice'            => $order->invoice_number,
            'customer'           => $order->customer->nama,
            'total_harga'        => $order->total_setelah_diskon, // tampilkan total setelah diskon
            'sisa_tagihan'       => $order->sisa_tagihan,
            'status_pembayaran'  => $order->status_pembayaran,
            'payments'           => $order->payments->map(function($p) {
                $buktiPath = $p->bukti_transfer;
                if ($buktiPath && is_string($buktiPath) && str_starts_with($buktiPath, '[')) {
                    $decoded = json_decode($buktiPath, true);
                    $buktiPath = is_array($decoded) && count($decoded) > 0 ? $decoded[0] : null;
                }
                return [
                    'tanggal' => $p->tanggal_bayar->format('d M Y'),
                    'jumlah'  => $p->jumlah,
                    'metode'  => $p->metode,
                    'tipe'    => $p->tipe,
                    'bukti'   => $buktiPath ? $this->publicFileUrl($buktiPath) : null,
                ];
            }),
        ]);
    }

    /**
     * AJAX: ambil detail pesanan untuk modal
     */
    public function detailPesanan(int $id)
    {
        $order = Order::with(['customer', 'details', 'details.size', 'details.logoItems', 'payments', 'hasilFotos'])->findOrFail($id);

        return response()->json([
            'id'               => $order->id,
            'invoice'          => $order->invoice_number,
            'customer'         => $order->customer->nama,
            'no_hp'            => $order->customer->no_hp,
            'alamat'           => $order->customer->alamat,
            'tanggal_pesan'    => $order->tanggal_pesan->format('d M Y'),
            'deadline'         => $order->deadline ? $order->deadline->format('d M Y') : '-',
            'total_harga_raw'  => $order->total_harga,
            'diskon_jenis'     => $order->diskon_jenis,
            'diskon_persen'    => $order->diskon_persen,
            'diskon_nominal'   => $order->diskon_nominal,
            'total_setelah_diskon' => $order->total_setelah_diskon,
            'dp'               => $order->dp,
            'sisa_tagihan'     => $order->sisa_tagihan,
            'status_produksi'  => $order->status_label,
            'status_pembayaran' => $order->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum',
            'details'          => $order->details->map(function ($d) {
                $ukuran = $d->size_custom ?? ($d->size ? $d->size->name : $d->ukuran);

                $logoItems = $d->logoItems->map(fn($li) => [
                    'logo' => $li->logo_path ? $this->publicFileUrl($li->logo_path) : null,
                    'keterangan_desain' => $li->keterangan_desain ?? '-',
                ])->values();

                if ($logoItems->isEmpty() && ($d->logo_path || $d->desain)) {
                    $logoItems = collect([[
                        'logo' => $d->logo_path ? $this->publicFileUrl($d->logo_path) : null,
                        'keterangan_desain' => $d->desain ?? '-',
                    ]]);
                }

                return [
                    'jenis_produk' => $d->jenis_produk,
                    'jumlah'       => $d->jumlah,
                    'ukuran'       => $ukuran ?? '-',
                    'bahan'        => $d->bahan ?? '-',
                    'warna'        => $d->warna ?? '-',
                    'desain'       => $d->desain ?? '-',
                    'harga_satuan' => $d->harga_satuan,
                    'subtotal'     => $d->subtotal,
                    'logo'         => $d->logo_path ? $this->publicFileUrl($d->logo_path) : null,
                    'logo_items'   => $logoItems,
                ];
            }),
            'payments'         => $order->payments->map(function ($p) {
                $buktiPath = $p->bukti_transfer;
                if ($buktiPath && is_string($buktiPath) && str_starts_with($buktiPath, '[')) {
                    $decoded = json_decode($buktiPath, true);
                    $buktiPath = is_array($decoded) && count($decoded) > 0 ? $decoded[0] : null;
                }
                return [
                    'tanggal' => $p->tanggal_bayar->format('d M Y'),
                    'jumlah'  => $p->jumlah,
                    'metode'  => ucfirst($p->metode),
                    'tipe'    => $p->tipe == 'dp' ? 'DP' : 'Pelunasan',
                    'bukti'   => $buktiPath ? $this->publicFileUrl($buktiPath) : null,
                ];
            }),
            'hasil_fotos'      => $order->hasilFotos->map(function ($hf) {
                return [
                    'id'          => $hf->id,
                    'url'         => $this->publicFileUrl($hf->foto_path),
                    'keterangan'  => $hf->keterangan,
                ];
            }),
        ]);
    }

    /** Cetak Kwitansi sebagai PDF */
    public function cetakKwitansi(int $id)
    {
        $order = Order::with(['customer', 'details.size', 'details.logoItems', 'payments'])->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('owner.kwitansi', compact('order'))
            ->setPaper('a5', 'portrait');

        return $pdf->download('Kwitansi_' . $order->invoice_number . '.pdf');
    }

    /** Cetak Surat Pesanan untuk Pegawai (tanpa harga) sebagai PDF */
    public function suratPesananPegawai(int $id)
    {
        $order = Order::with(['customer', 'details.size', 'details.logoItems'])->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('owner.surat_pesanan_pegawai', compact('order'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Surat_Pesanan_' . $order->invoice_number . '.pdf');
    }

    /** Upload foto hasil produksi (bisa multi) */
    public function storeHasilFoto(Request $request, int $orderId)
    {
        $request->validate([
            'foto_hasil'   => 'required|array|min:1',
            'foto_hasil.*' => 'required|file|image|mimes:jpeg,png,jpg|max:5120',
            'keterangan'   => 'nullable|string|max:255',
        ]);

        $order = Order::findOrFail($orderId);

        foreach ($request->file('foto_hasil') as $foto) {
            $path = $this->saveUploadedFileToPublic($foto, 'order_hasil');
            $order->hasilFotos()->create([
                'foto_path'  => $path,
                'keterangan' => $request->keterangan,
            ]);
        }

        return back()->with('success', 'Foto hasil produksi berhasil diupload.');
    }

    /** Hapus satu foto hasil produksi */
    public function destroyHasilFoto(int $fotoId)
    {
        $foto = OrderHasilFoto::findOrFail($fotoId);
        $filePath = public_path($foto->foto_path);
        if (is_file($filePath)) {
            @unlink($filePath);
        }
        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
    /**
     * Simpan file upload langsung ke folder public agar URL asset($path) langsung bisa dibuka di Laragon.
     * Path yang disimpan ke database tetap pendek, contoh: order_logos/namafile.jpg.
     */
    private function saveUploadedFileToPublic($file, string $folder): string
    {
        $folder = trim($folder, '/');
        $targetDir = public_path($folder);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'file');
        $filename = uniqid('', true) . '_' . time() . '.' . $extension;

        $file->move($targetDir, $filename);

        return $folder . '/' . $filename;
    }

    /**
     * Buat URL file yang aman untuk data lama dan data baru.
     * Prioritas:
     * 1. public/order_logos atau public/payment_proofs  -> asset($path)
     * 2. storage/app/public/... jika storage:link aktif -> asset('storage/'.$path)
     */
    private function publicFileUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $path = $this->normalizeUploadPath($path);

        // Jangan langsung pakai /order_logos atau /storage lagi.
        // Lewat route Laravel supaya file pasti bisa dibaca dari public/ atau storage/app/public/.
        return route('owner.file.preview', ['path' => $path]);
    }

    private function normalizeUploadPath(string $path): string
    {
        $path = trim(str_replace('\\', '/', $path));
        $path = urldecode($path);
        $path = ltrim($path, '/');
        $path = preg_replace('#^public/#', '', $path);
        $path = preg_replace('#^storage/#', '', $path);
        $path = str_replace(['../', '..\\'], '', $path);

        return $path;
    }

    public function previewFile(Request $request)
    {
        $request->validate([
            'path' => 'required|string|max:500',
        ]);

        $path = $this->normalizeUploadPath($request->query('path'));

        // Keamanan: hanya izinkan folder upload yang dipakai project ini.
        $allowedFolders = ['order_logos/', 'payment_proofs/', 'order_hasil/', 'pengeluaran_notas/', 'acak_images/', 'pengeluaran_nota/'];
        $allowed = false;
        foreach ($allowedFolders as $folder) {
            if (str_starts_with($path, $folder)) {
                $allowed = true;
                break;
            }
        }
        if (!$allowed) {
            abort(403, 'Folder file tidak diizinkan.');
        }

        $candidates = [
            public_path($path),
            public_path('storage/' . $path),
            storage_path('app/public/' . $path),
        ];

        foreach ($candidates as $file) {
            if (is_file($file)) {
                return response()->file($file, [
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }
        }

        abort(404, 'File tidak ditemukan: ' . $path);
    }

}
