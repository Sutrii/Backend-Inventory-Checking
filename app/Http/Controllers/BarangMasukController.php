<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        return response()->json(BarangMasuk::all());
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
                'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'work_unit' => 'required|string',
            ]);

            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Get the original file name with a timestamp prefix
                $filePath = $file->storeAs('public/pictures', $fileName); // Store in 'storage/app/public/pictures'
                $validated['picture'] = $fileName; // Save only the file name in the database
            } else {
                $validated['picture'] = null; // Set picture to null if not provided
            }

            $barangMasuk = BarangMasuk::create($validated);

            return response()->json($barangMasuk, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        $barangMasuk = BarangMasuk::find($id);

        if (!$barangMasuk) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($barangMasuk);
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

}

