<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    protected $fillable = [
        'kategori',
        'judul',
        'deskripsi',
        'gambar_list',
    ];

    protected $casts = [
        'gambar_list' => 'array',
    ];
}
