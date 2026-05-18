<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'jenis_produk',
        'jumlah',
        'ukuran',
        'bahan',
        'warna',
        'desain',
        'harga_satuan',
        'subtotal',
        'logo_path',
        'size_id',
        'size_custom'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
