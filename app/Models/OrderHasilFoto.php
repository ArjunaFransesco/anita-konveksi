<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHasilFoto extends Model
{
    protected $fillable = [
        'order_id',
        'foto_path',
        'keterangan',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
