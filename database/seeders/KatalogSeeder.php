<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Katalog;

class KatalogSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kategori' => 'seragam-sekolah',
                'judul' => 'Seragam Sekolah',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi untuk Seragam Sekolah',
                'gambar_list' => [
                    'images/portofolio/seragam-sekolah/1.jpg',
                    'images/portofolio/seragam-sekolah/2.jpg',
                    'images/portofolio/seragam-sekolah/3.jpg',
                    'images/portofolio/seragam-sekolah/4.jpg',
                    'images/portofolio/seragam-sekolah/5.jpg',
                ]
            ],
            [
                'kategori' => 'seragam-kantor',
                'judul' => 'Seragam Kantor',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi untuk Seragam Kantor',
                'gambar_list' => [
                    'images/portofolio/seragam-kantor/1.jpg',
                    'images/portofolio/seragam-kantor/2.jpg',
                    'images/portofolio/seragam-kantor/3.jpg',
                ]
            ],
            [
                'kategori' => 'seragam-drumband',
                'judul' => 'Seragam Drumband',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi untuk Seragam Drumband',
                'gambar_list' => [
                    'images/portofolio/seragam-drumband/1.jpg',
                    'images/portofolio/seragam-drumband/2.jpg',
                    'images/portofolio/seragam-drumband/3.jpg',
                ]
            ],
            [
                'kategori' => 'jas-almamater',
                'judul' => 'Jas Almamater',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi untuk Jas Almamater',
                'gambar_list' => [
                    'images/portofolio/jas-almamater/1.jpg',
                    'images/portofolio/jas-almamater/2.jpg',
                    'images/portofolio/jas-almamater/3.jpg',
                ]
            ],
            [
                'kategori' => 'umbul-umbul',
                'judul' => 'Umbul Umbul',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi untuk Umbul Umbul',
                'gambar_list' => [
                    'images/portofolio/umbul-umbul/1.jpg',
                    'images/portofolio/umbul-umbul/2.jpg',
                    'images/portofolio/umbul-umbul/3.jpg',
                ]
            ],
            [
                'kategori' => 'topi',
                'judul' => 'Topi',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi untuk Topi',
                'gambar_list' => [
                    'images/portofolio/topi/1.jpg',
                    'images/portofolio/topi/2.jpg',
                    'images/portofolio/topi/3.jpg',
                ]
            ],
            [
                'kategori' => 'jaket',
                'judul' => 'Jaket',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi untuk Jaket',
                'gambar_list' => [
                    'images/portofolio/jaket/1.jpg',
                    'katalog_images/WhatsApp Image 2026-06-15 at 23.42.36.jpeg',
                    'katalog_images/WhatsApp Image 2026-06-15 at 23.42.37.jpeg',
                ]
            ],
            [
                'kategori' => 'pdl',
                'judul' => 'Pdl',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi untuk Pdl',
                'gambar_list' => [
                    'images/portofolio/pdl/1.jpg',
                    'images/portofolio/pdl/2.jpg',
                    'images/portofolio/pdl/3.jpg',
                ]
            ],
            [
                'kategori' => 'dll',
                'judul' => 'Dll',
                'deskripsi' => 'Kualitas terbaik dari Anita Konveksi',
                'gambar_list' => [
                    'images/portofolio/dll/1.jpg',
                    'images/portofolio/dll/2.jpg',
                    'images/portofolio/dll/3.jpg',
                    'images/portofolio/dll/4.jpg',
                ]
            ]
        ];

        foreach ($data as $item) {
            Katalog::updateOrCreate(
                ['kategori' => $item['kategori']],
                [
                    'judul' => $item['judul'],
                    'deskripsi' => $item['deskripsi'],
                    'gambar_list' => $item['gambar_list']
                ]
            );
        }
    }
}
