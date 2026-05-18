<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'tanggal_pesan',
        'deadline',
        'total_harga',
        'dp',
        'sisa_tagihan',
        'status_produksi',
        'status_pembayaran',
        'diskon_persen',
        'total_setelah_diskon',
        'invoice_number',
        'customer_id',
        'tanggal_pesan',
        'deadline',
        'total_harga',
        'diskon_persen',
        'total_setelah_diskon',
        'dp',
        'sisa_tagihan',
        'status_produksi',
        'status_pembayaran'
    ];

    protected $casts = [
        'tanggal_pesan' => 'date',
        'deadline'      => 'date',
        'total_harga'   => 'decimal:2',
        'dp'            => 'decimal:2',
        'sisa_tagihan'  => 'decimal:2',
    ];


    // ---------- Status labels ----------
    public static array $statusProduksiLabels = [
        'nunggu_konfirmasi'   => 'Nunggu Konfirmasi',
        'menunggu_bahan'      => 'Menunggu Bahan',
        'proses_potong'       => 'Proses Potong',
        'proses_jahit'        => 'Proses Jahit',
        'proses_sablon_bordir' => 'Proses Sablon/Bordir',
        'quality_control'     => 'Quality Control',
        'siap_diambil'        => 'Siap Diambil',
        'selesai'             => 'Selesai',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::$statusProduksiLabels[$this->status_produksi] ?? $this->status_produksi;
    }

    // ---------- Urutan progres ----------
    public function getProgressAttribute(): int
    {
        $keys = array_keys(self::$statusProduksiLabels);
        $idx  = array_search($this->status_produksi, $keys);
        return $idx !== false ? (int) round(($idx / (count($keys) - 1)) * 100) : 0;
    }

    // ---------- Relations ----------
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ---------- Auto-generate invoice ----------
    public static function generateInvoice(): string
    {
        $year  = now()->format('Y');
        $last  = static::whereYear('created_at', $year)->count() + 1;
        return 'INV-' . $year . '-' . str_pad($last, 3, '0', STR_PAD_LEFT);
    }
}
