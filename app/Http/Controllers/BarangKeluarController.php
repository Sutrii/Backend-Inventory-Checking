<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index()
    {
        return response()->json(BarangKeluar::all());
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'nama_barang' => 'required|string',
            'tipe_barang' => 'required|string',
            'kualitas' => 'required|string',
            'tanggal' => 'required|date',
            'sn' => 'required|string',
            'jumlah' => 'required|integer',
            'satuan' => 'required|string',
            'keterangan' => 'required|string',
            'lokasi' => 'required|string',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'work_unit' => 'required|string',
        ]);

        // Handle file upload
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('pictures', 'public');
            $validated['picture'] = $picturePath;
        }

        $barangKeluar = BarangKeluar::create($validated);

        return response()->json($barangKeluar, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}

