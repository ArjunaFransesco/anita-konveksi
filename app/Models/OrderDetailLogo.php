<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetailLogo extends Model
{
    protected $fillable = [
        'order_detail_id',
        'logo_path',
        'keterangan_desain',
    ];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
