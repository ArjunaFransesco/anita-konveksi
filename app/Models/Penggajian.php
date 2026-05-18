<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'bulan',
        'minggu_ke',
        'hari_kerja',
        'total_gaji',
        'status',
        'tanggal_bayar',
    ];

    protected $casts = [
        'hari_kerja'    => 'decimal:2',
        'total_gaji'    => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
