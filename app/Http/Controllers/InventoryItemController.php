<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                'nama_peminjam' => 'nullable|string',
                'divisi_peminjam' => 'nullable|string',
                'tipe_barang' => 'required|string',
                'kualitas' => 'required|string',
                'tanggal' => 'nullable|date',
                'tanggal_awal_pinjam' => 'nullable|date',
                'tanggal_akhir_pinjam' => 'nullable|date',
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
                // Storage::disk('public/pictures')->put($fileName, file_get_contents($request->picture));
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

    public function update(Request $request, $id)
    {
        try {
            \Log::info('Update Request Data:', $request->all());
            $data = $request->all();
            $inventoryItem = InventoryItem::findOrFail($id);

            if ($request->hasFile('picture')) {
                // Delete the old picture if it exists
                if ($inventoryItem->picture) {
                    Storage::delete('public/pictures/' . $inventoryItem->picture);
                }
                $file = $request->file('picture');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('public/pictures', $fileName);
                $data['picture'] = $fileName;
            } else {
                unset($data['picture']);
            }

            $inventoryItem->update($data);
            return response()->json(['message' => 'Data successfully updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating data!'], 500);
        }
    }

    public function show($id)
    {
        $inventoryItem = InventoryItem::find($id);

        if (!$inventoryItem) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($inventoryItem);
    }

    public function destroy($id)
    {
        $inventoryItem = InventoryItem::findOrFail($id);

        // Delete the picture if it exists
        if ($inventoryItem->picture) {
            Storage::delete('public/pictures/' . $inventoryItem->picture);
        }

        $inventoryItem->delete();
        return response()->json(['message' => 'Data successfully deleted'], 200);
    }
}
