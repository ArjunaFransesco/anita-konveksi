<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KatalogController extends Controller
{
    public function index()
    {
        $katalogs = Katalog::latest()->get();
        return view('admin.katalog.index', compact('katalogs'));
    }

    public function create()
    {
        return view('admin.katalog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|unique:katalogs,kategori|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar.*' => 'nullable|image|max:5120'
        ]);

        $gambarList = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                // Move directly to public/katalog_images
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('katalog_images'), $fileName);
                $gambarList[] = 'katalog_images/' . $fileName;
            }
        }

        Katalog::create([
            'kategori' => Str::slug($request->kategori),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar_list' => $gambarList,
        ]);

        return redirect()->route('admin.katalog.index')->with('success', 'Katalog berhasil ditambahkan');
    }

    public function edit(Katalog $katalog)
    {
        return view('admin.katalog.edit', compact('katalog'));
    }

    public function update(Request $request, Katalog $katalog)
    {
        $request->validate([
            'kategori' => 'required|string|max:255|unique:katalogs,kategori,' . $katalog->id,
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar.*' => 'nullable|image|max:5120',
            'hapus_gambar' => 'nullable|array'
        ]);

        $gambarList = $katalog->gambar_list ?? [];

        // Remove deleted images
        if ($request->has('hapus_gambar')) {
            foreach ($request->hapus_gambar as $hapus) {
                if (($key = array_search($hapus, $gambarList)) !== false) {
                    unset($gambarList[$key]);
                    // Delete physically if exists
                    if (file_exists(public_path($hapus))) {
                        unlink(public_path($hapus));
                    }
                }
            }
            $gambarList = array_values($gambarList); // Reindex
        }

        // Add new images
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('katalog_images'), $fileName);
                $gambarList[] = 'katalog_images/' . $fileName;
            }
        }

        $katalog->update([
            'kategori' => Str::slug($request->kategori),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar_list' => $gambarList,
        ]);

        return redirect()->route('admin.katalog.index')->with('success', 'Katalog berhasil diperbarui');
    }

    public function destroy(Katalog $katalog)
    {
        // Delete all physical files
        if (is_array($katalog->gambar_list)) {
            foreach ($katalog->gambar_list as $g) {
                if (file_exists(public_path($g))) {
                    unlink(public_path($g));
                }
            }
        }
        
        $katalog->delete();
        return redirect()->route('admin.katalog.index')->with('success', 'Katalog berhasil dihapus');
    }
}
