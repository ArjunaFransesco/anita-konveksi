<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'tanggal_bayar',
        'jumlah',
        'metode',
        'bukti_transfer',
        'tipe',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah'        => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
