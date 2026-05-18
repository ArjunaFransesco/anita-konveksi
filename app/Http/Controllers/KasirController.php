<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Size; // tambahkan jika perlu

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
            'logo.*'            => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
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

                // Upload logo
                $logoPath = null;
                if ($request->hasFile("logo.$i")) {
                    $file = $request->file("logo.$i");
                    $logoPath = $file->store('order_logos', 'public');
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
                    'desain'       => $request->desain[$i] ?? null,
                    'harga_satuan' => $harga,
                    'subtotal'     => $subtotal,
                    'logo_path'    => $logoPath,
                    'size_id'      => $sizeId,
                    'size_custom'  => $sizeCustom,
                ];
            }

            // Diskon 5% jika total qty > 10
            $diskonPersen = ($totalQty > 10) ? 5 : 0;
            $diskonNominal = $totalRaw * ($diskonPersen / 100);
            $totalSetelahDiskon = $totalRaw - $diskonNominal;

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
                'diskon_persen'        => $diskonPersen,
                'total_setelah_diskon' => $totalSetelahDiskon,
                'dp'                   => $dp,
                'sisa_tagihan'         => $sisaTagihan,
                'status_produksi'      => 'nunggu_konfirmasi',
                'status_pembayaran'    => $statusBayar,
            ]);

            // 5. Detail order
            foreach ($details as $d) {
                $order->details()->create($d);
            }

            // 6. Catat pembayaran (jika ada DP atau lunas)
            if ($dp > 0) {
                $order->payments()->create([
                    'tanggal_bayar' => now()->toDateString(),
                    'jumlah'        => $dp,
                    'metode'        => $metodeDp,
                    'tipe'          => ($tipePembayaran === 'lunas') ? 'pelunasan' : 'dp',
                    'catatan'       => $tipePembayaran === 'lunas' ? 'Lunas saat input pesanan' : 'DP awal',
                ]);
            }
        });

        return redirect()->route('kasir.pesanan.index')
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

        return redirect()->route('kasir.pesanan.index')
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
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::findOrFail($request->order_id);

            $order->payments()->create([
                'tanggal_bayar' => $request->tanggal_bayar,
                'jumlah'        => $request->jumlah,
                'metode'        => $request->metode,
                'tipe'          => $request->tipe,
                'catatan'       => $request->catatan,
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

        return redirect()->route('kasir.pembayaran.catat')
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
            'payments'           => $order->payments->map(fn($p) => [
                'tanggal' => $p->tanggal_bayar->format('d M Y'),
                'jumlah'  => $p->jumlah,
                'metode'  => $p->metode,
                'tipe'    => $p->tipe,
            ]),
        ]);
    }

    /**
     * AJAX: ambil detail pesanan untuk modal
     */
    public function detailPesanan(int $id)
    {
        $order = Order::with(['customer', 'details', 'details.size', 'payments'])->findOrFail($id);

        return response()->json([
            'id'               => $order->id,
            'invoice'          => $order->invoice_number,
            'customer'         => $order->customer->nama,
            'no_hp'            => $order->customer->no_hp,
            'alamat'           => $order->customer->alamat,
            'tanggal_pesan'    => $order->tanggal_pesan->format('d M Y'),
            'deadline'         => $order->deadline ? $order->deadline->format('d M Y') : '-',
            'total_harga_raw'  => $order->total_harga,
            'diskon_persen'    => $order->diskon_persen,
            'total_setelah_diskon' => $order->total_setelah_diskon,
            'dp'               => $order->dp,
            'sisa_tagihan'     => $order->sisa_tagihan,
            'status_produksi'  => $order->status_label,
            'status_pembayaran' => $order->status_pembayaran == 'lunas' ? 'Lunas' : 'Belum',
            'details'          => $order->details->map(function ($d) {
                $ukuran = $d->size_custom ?? ($d->size ? $d->size->name : $d->ukuran);
                return [
                    'jenis_produk' => $d->jenis_produk,
                    'jumlah'       => $d->jumlah,
                    'ukuran'       => $ukuran ?? '-',
                    'bahan'        => $d->bahan ?? '-',
                    'warna'        => $d->warna ?? '-',
                    'desain'       => $d->desain ?? '-',
                    'harga_satuan' => $d->harga_satuan,
                    'subtotal'     => $d->subtotal,
                    'logo'         => $d->logo_path ? asset('storage/' . $d->logo_path) : null,
                ];
            }),
            'payments'         => $order->payments->map(function ($p) {
                return [
                    'tanggal' => $p->tanggal_bayar->format('d M Y'),
                    'jumlah'  => $p->jumlah,
                    'metode'  => ucfirst($p->metode),
                    'tipe'    => $p->tipe == 'dp' ? 'DP' : 'Pelunasan',
                ];
            }),
        ]);
    }
}
