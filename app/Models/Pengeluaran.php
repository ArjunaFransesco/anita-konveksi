<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'tanggal',
        'tipe',
        'keterangan',
        'jumlah',
        'metode',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    public static array $tipeLabels = [
        'bahan_baku'  => 'Bahan Baku',
        'gaji'        => 'Gaji / Upah',
        'operasional' => 'Operasional',
        'listrik_air' => 'Listrik & Air',
        'lain_lain'   => 'Lain-lain',
    ];

    public function getTipeLabelAttribute(): string
    {
        return self::$tipeLabels[$this->tipe] ?? $this->tipe;
    }
}
