<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Delete previous dummy data starting from INV-2026-011
        $dummyOrders = Order::where('invoice_number', '>=', 'INV-2026-011')->get();
        foreach ($dummyOrders as $order) {
            $order->details()->delete();
            $order->payments()->delete();
            $order->delete();
        }
        Pengeluaran::where('keterangan', 'like', 'Belanja keperluan %')->delete();

        // 2. Fetch random images from public/acak_images
        $imageFiles = glob(public_path('acak_images/*.*'));
        $images = array_map(function($path) {
            return 'acak_images/' . basename($path);
        }, $imageFiles);

        $getRandomImage = function() use ($images) {
            if (empty($images)) return null;
            return $images[array_rand($images)];
        };

        // 3. Ensure we have Indonesian Customers
        $names = ['Budi Santoso', 'Siti Aminah', 'Joko Widodo', 'Rina Sari', 'Agus Setiawan', 'Dewi Lestari', 'Wahyu Hidayat', 'Sri Rahayu', 'Hendra Gunawan', 'Fitriani', 'Andi Pratama', 'Nurul Huda', 'Eko Saputro', 'Dian Sastrowardoyo', 'Bambang Pamungkas'];
        $customers = [];
        foreach ($names as $idx => $name) {
            // Check if already exists to avoid duplication if running multiple times
            $customer = Customer::firstOrCreate(
                ['nama' => $name],
                [
                    'no_hp' => "0812" . rand(10000000, 99999999),
                    'alamat' => "Jl. Merdeka No. " . rand(1, 100) . ", Jakarta"
                ]
            );
            $customers[] = $customer;
        }

        // 4. Create 30 Dummy Orders with highly varied data
        $statuses = ['nunggu_konfirmasi', 'menunggu_bahan', 'proses_potong', 'proses_jahit', 'proses_sablon_bordir', 'quality_control', 'siap_diambil', 'selesai'];
        $jenisProdukList = ['Kaos Polo', 'Kemeja PDH', 'Jaket Bomber', 'Topi Trucker', 'Totebag Kanvas', 'Seragam Olahraga'];
        $bahanList = ['Combed 30s', 'American Drill', 'Taslan', 'Rafel', 'Kanvas 10oz', 'Lotto'];
        $posisiLogoList = ['Dada Kiri', 'Dada Kanan', 'Lengan Kanan', 'Lengan Kiri', 'Punggung Tengah', 'Tengkuk Leher', 'Saku Depan', 'Topi Depan', 'Samping Totebag'];
        
        $invoiceCounter = 11; // Start from 011
        
        foreach ($customers as $customer) {
            // Give each customer 2 orders (15 * 2 = 30 orders total)
            for ($j = 1; $j <= 2; $j++) {
                
                // Determine how many products in this order (1 to 3)
                $numProducts = rand(1, 3);
                $totalHarga = 0;
                $detailsData = [];
                
                for ($p = 1; $p <= $numProducts; $p++) {
                    $jumlah = rand(10, 50);
                    $hargaSatuan = rand(25, 120) * 1000;
                    $subtotal = $jumlah * $hargaSatuan;
                    $totalHarga += $subtotal;
                    
                    $hasLogo = rand(1, 100) <= 80; // 80% chance to have a custom logo design
                    $logoPath = $hasLogo ? $getRandomImage() : null;
                    $desainText = $hasLogo && $logoPath ? $posisiLogoList[array_rand($posisiLogoList)] : null;

                    $detailsData[] = [
                        'jenis_produk' => $jenisProdukList[array_rand($jenisProdukList)],
                        'jumlah' => $jumlah,
                        'ukuran' => ['S','M','L','XL','XXL'][rand(0,4)],
                        'bahan' => $bahanList[array_rand($bahanList)],
                        'warna' => ['Hitam', 'Putih', 'Navy', 'Merah', 'Abu-abu'][rand(0,4)],
                        'desain' => $desainText,
                        'harga_satuan' => $hargaSatuan,
                        'subtotal' => $subtotal,
                        'logo_path' => $logoPath,
                    ];
                }

                // Random DP and Lunas logic
                $isLunas = rand(0, 1) == 1; // 50% chance to be fully paid
                $dp = 0;
                
                if ($isLunas) {
                    $dp = $totalHarga; // Paid in full
                } else {
                    $hasDp = rand(0, 1) == 1; // 50% chance to have DP, 50% chance no DP yet
                    if ($hasDp) {
                        $dp = floor(rand(30, 70) / 100 * $totalHarga); // DP between 30% and 70%
                    }
                }
                
                $sisaTagihan = $totalHarga - $dp;
                
                $order = Order::create([
                    'invoice_number' => 'INV-2026-' . str_pad($invoiceCounter++, 3, '0', STR_PAD_LEFT),
                    'customer_id' => $customer->id,
                    'tanggal_pesan' => Carbon::now()->subDays(rand(1, 60)),
                    'deadline' => Carbon::now()->addDays(rand(1, 20)),
                    'total_harga' => $totalHarga,
                    'diskon_jenis' => 'persen',
                    'diskon_tipe' => 'none',
                    'diskon_persen' => 0,
                    'diskon_nominal' => 0,
                    'total_setelah_diskon' => $totalHarga,
                    'dp' => $dp,
                    'sisa_tagihan' => $sisaTagihan,
                    'status_produksi' => $statuses[array_rand($statuses)],
                    'status_pembayaran' => $sisaTagihan <= 0 ? 'lunas' : 'belum',
                ]);

                // Insert Details
                foreach ($detailsData as $d) {
                    $d['order_id'] = $order->id;
                    OrderDetail::create($d);
                }

                // Create Payment History
                if ($dp > 0) {
                    // Initial DP or Full Payment
                    Payment::create([
                        'order_id' => $order->id,
                        'tanggal_bayar' => $order->tanggal_pesan,
                        'jumlah' => $isLunas ? floor($totalHarga * 0.5) : $dp, // If lunas, pretend DP was 50%
                        'metode' => ['transfer', 'tunai'][rand(0, 1)],
                        'tipe' => 'dp',
                        'catatan' => 'Pembayaran Awal',
                        'bukti_transfer' => (rand(1, 100) <= 80) ? $getRandomImage() : null,
                    ]);
                    
                    // If lunas, add pelunasan
                    if ($isLunas) {
                        Payment::create([
                            'order_id' => $order->id,
                            'tanggal_bayar' => Carbon::parse($order->tanggal_pesan)->addDays(rand(1, 5)),
                            'jumlah' => $totalHarga - floor($totalHarga * 0.5),
                            'metode' => ['transfer', 'tunai'][rand(0, 1)],
                            'tipe' => 'pelunasan',
                            'catatan' => 'Pelunasan Akhir',
                            'bukti_transfer' => (rand(1, 100) <= 80) ? $getRandomImage() : null,
                        ]);
                    }
                }
            }
        }

        // 5. Create Dummy Pengeluaran
        $pengeluaranTipe = ['bahan_baku', 'gaji', 'operasional', 'listrik_air', 'lain_lain'];
        for ($k = 1; $k <= 15; $k++) {
            Pengeluaran::create([
                'tanggal' => Carbon::now()->subDays(rand(1, 40)),
                'tipe' => $pengeluaranTipe[array_rand($pengeluaranTipe)],
                'keterangan' => "Belanja keperluan " . $pengeluaranTipe[array_rand($pengeluaranTipe)] . " " . $k,
                'jumlah' => rand(2, 50) * 50000,
                'metode' => ['tunai', 'transfer'][rand(0, 1)],
                'catatan' => 'Testing data pengeluaran',
                'foto_nota' => (rand(1, 100) <= 70) ? $getRandomImage() : null,
            ]);
        }
    }
}
