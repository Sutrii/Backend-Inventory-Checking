<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index()
    {
        return response()->json(InventoryItem::all());
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kategori_input' => 'required|string',
                'nama_barang' => 'required|string',
                'tipe_barang' => 'required|string',
                'kualitas' => 'required|string',
                'tanggal' => 'required|date',
                'tanggal_awal_pinjaman' => 'nullable|date',
                'tanggal_akhir_pinjaman' => 'nullable|date',
                'sn' => 'required|string',
                'jumlah' => 'required|integer',
                'satuan' => 'required|string',
                'keterangan' => 'nullable|string',
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

            $inventoryItem = InventoryItem::create($validated);

            return response()->json($inventoryItem, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryItem $inventoryItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        //
    }
}
