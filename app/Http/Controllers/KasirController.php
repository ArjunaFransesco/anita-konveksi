<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Payment;

class KasirController extends Controller
{
    // ─────────────────────────────────────────────
    //  INPUT PESANAN
    // ─────────────────────────────────────────────

    /** GET: tampil form input pesanan */
    public function inputPesanan()
    {
        return view('kasir.input_pesanan');
    }

    /** POST: simpan pesanan baru */
    public function storePesanan(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:100',
            'no_hp'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
            'deadline'     => 'nullable|date',
            'dp'           => 'nullable|numeric|min:0',
            // detail produk (array)
            'jenis_produk'  => 'required|array|min:1',
            'jenis_produk.*'=> 'required|string|max:100',
            'jumlah.*'      => 'required|integer|min:1',
            'harga_satuan.*'=> 'required|numeric|min:0',
            // opsional per baris
            'ukuran.*'      => 'nullable|string|max:20',
            'bahan.*'       => 'nullable|string|max:100',
            'warna.*'       => 'nullable|string|max:50',
            'desain.*'      => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            // 1. Simpan / cari pelanggan
            $customer = Customer::firstOrCreate(
                ['no_hp' => $request->no_hp ?? null],
                ['nama'  => $request->nama, 'alamat' => $request->alamat]
            );
            // update nama jika sudah ada
            $customer->update(['nama' => $request->nama, 'alamat' => $request->alamat]);

            // 2. Hitung total dari detail
            $totalHarga = 0;
            $details = [];
            foreach ($request->jenis_produk as $i => $jenis) {
                $qty      = (int)   ($request->jumlah[$i]       ?? 1);
                $harga    = (float) ($request->harga_satuan[$i] ?? 0);
                $subtotal = $qty * $harga;
                $totalHarga += $subtotal;
                $details[] = [
                    'jenis_produk' => $jenis,
                    'jumlah'       => $qty,
                    'ukuran'       => $request->ukuran[$i]  ?? null,
                    'bahan'        => $request->bahan[$i]   ?? null,
                    'warna'        => $request->warna[$i]   ?? null,
                    'desain'       => $request->desain[$i]  ?? null,
                    'harga_satuan' => $harga,
                    'subtotal'     => $subtotal,
                ];
            }

            $dp          = (float) ($request->dp ?? 0);
            $sisaTagihan = $totalHarga - $dp;

            // 3. Buat order
            $order = Order::create([
                'invoice_number'   => Order::generateInvoice(),
                'customer_id'      => $customer->id,
                'tanggal_pesan'    => now()->toDateString(),
                'deadline'         => $request->deadline,
                'total_harga'      => $totalHarga,
                'dp'               => $dp,
                'sisa_tagihan'     => max(0, $sisaTagihan),
                'status_produksi'  => 'nunggu_konfirmasi',
                'status_pembayaran'=> $sisaTagihan <= 0 ? 'lunas' : 'belum',
            ]);

            // 4. Simpan detail produk
            foreach ($details as $d) {
                $order->details()->create($d);
            }

            // 5. Catat DP jika ada
            if ($dp > 0) {
                $order->payments()->create([
                    'tanggal_bayar' => now()->toDateString(),
                    'jumlah'        => $dp,
                    'metode'        => $request->metode_dp ?? 'tunai',
                    'tipe'          => 'dp',
                    'catatan'       => 'DP awal saat input pesanan',
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
        // Pesanan yang belum lunas (untuk dropdown)
        $orders = Order::with('customer')
            ->where('status_pembayaran', 'belum')
            ->orderByDesc('created_at')
            ->get();

        // Jika ada order dipilih langsung
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
            'order_id'     => 'required|exists:orders,id',
            'jumlah'       => 'required|numeric|min:1',
            'metode'       => 'required|in:tunai,transfer',
            'tipe'         => 'required|in:dp,pelunasan',
            'tanggal_bayar'=> 'required|date',
            'catatan'      => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $order = Order::findOrFail($request->order_id);

            // Simpan payment
            $order->payments()->create([
                'tanggal_bayar' => $request->tanggal_bayar,
                'jumlah'        => $request->jumlah,
                'metode'        => $request->metode,
                'tipe'          => $request->tipe,
                'catatan'       => $request->catatan,
            ]);

            // Hitung ulang sisa tagihan
            $totalBayar  = $order->payments()->sum('jumlah');
            $sisa        = $order->total_harga - $totalBayar;
            $statusBayar = $sisa <= 0 ? 'lunas' : 'belum';

            $order->update([
                'dp'               => $order->payments()->where('tipe', 'dp')->sum('jumlah'),
                'sisa_tagihan'     => max(0, $sisa),
                'status_pembayaran'=> $statusBayar,
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
            'invoice'          => $order->invoice_number,
            'customer'         => $order->customer->nama,
            'total_harga'      => $order->total_harga,
            'sisa_tagihan'     => $order->sisa_tagihan,
            'status_pembayaran'=> $order->status_pembayaran,
            'payments'         => $order->payments->map(fn($p) => [
                'tanggal' => $p->tanggal_bayar->format('d M Y'),
                'jumlah'  => $p->jumlah,
                'metode'  => $p->metode,
                'tipe'    => $p->tipe,
            ]),
        ]);
    }
}
