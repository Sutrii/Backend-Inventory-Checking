<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InventoryItemController extends Controller
{
    public function index()
    {
        return response()->json(InventoryItem::all());
    }

    public function generatePdf(Request $request, $id)
    {
        // Cari dokumen pendukung pejabat berdasarkan id
        $dokumen = InventoryItem::findOrFail($id);
    
        // Tentukan jenis dokumen yang ingin diunduh (misalnya: dokumen pelengkap)
        $jenisDokumen = 'bukti'; // Sesuaikan dengan jenis dokumen yang diinginkan
    
        // Dapatkan nama file dari model sesuai jenis dokumen yang diinginkan
        $fileNames = json_decode($dokumen->$jenisDokumen);
    
        // Periksa apakah daftar file kosong atau tidak
        if (empty($fileNames)) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }
    
        // Ambil file pertama dalam daftar file
        $fileName = $fileNames[0];
    
        // Dapatkan path lengkap dari file
        $folderPath = 'public/bukti' . $jenisDokumen . '/';
        $filePath = public_path($folderPath . $fileName);
    
        // Periksa apakah file ada
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    
        // Tampilkan file PDF kepada pengguna
        return response()->file($filePath);
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
                'tujuan_keluar' => 'nullable|string',
                'status_barang' => 'nullable|string',
                'solusi_barang' => 'nullable|string',
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
                'bukti' => 'nullable|file|mimes:pdf|max:2048',
                'work_unit' => 'required|string',
            ]);

            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $fileName = $file->getClientOriginalName(); // Gunakan nama file asli
                $filePath = $file->storeAs('public/pictures', $fileName); // Simpan file dengan nama asli
                $validated['picture'] = $fileName; // Simpan nama file asli di database
            } else {
                $validated['picture'] = null;
            }

            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $fileName = $file->getClientOriginalName(); // Gunakan nama file asli
                $file->storeAs('public/bukti', $fileName); // Simpan file dengan nama asli
                $validated['bukti'] = $fileName; // Simpan nama file ke dalam field `bukti`
            } else {
                $validated['bukti'] = null; // Set field `bukti` to null if no file is uploaded
            }
    
            $inventoryItem = InventoryItem::create($validated);
    
            return response()->json($inventoryItem, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $data = $request->all();
    //         $inventoryItem = InventoryItem::findOrFail($id);
            
    //         if ($request->hasFile('picture')) {
    //             $file = $request->file('picture');
    //             $fileName = time() . '_' . $file->getClientOriginalName(); // Get the original file name with a timestamp prefix
    //             // Storage::disk('public/pictures')->put($fileName, file_get_contents($request->picture));
    //             $filePath = $file->storeAs('public/pictures', $fileName); // Store in 'storage/app/public/pictures'
    //             $validated['picture'] = $fileName; // Save only the file name in the database
    //         } else {
    //             $validated['picture'] = null; // Set picture to null if not provided
    //         }

    //         $inventoryItem->update($data);
    //         return response()->json(['message' => 'Data berhasil diperbarui'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Terjadi kesalahan saat memperbarui data!'], 500);
    //     }
    // }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            \Log::info('Request Data:', $data);

            $inventoryItem = InventoryItem::findOrFail($id);

            // Jika ada file gambar yang diupload
            if ($request->hasFile('picture')) {
                $file = $request->file('picture');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Gunakan nama file dengan timestamp
                $filePath = $file->storeAs('public/pictures', $fileName); // Simpan file dengan nama yang unik
                $data['picture'] = $fileName;
            }
            
            if ($request->hasFile('bukti')) {
                $file = $request->file('bukti');
                $fileName = time() . '_' . $file->getClientOriginalName(); // Gunakan nama file dengan timestamp
                $file->storeAs('public/bukti', $fileName); // Simpan file dengan nama yang unik
                $data['bukti'] = $fileName;
            }
            

            $inventoryItem->update($data);
            \Log::info('Updated Data:', $inventoryItem->toArray());

            return response()->json(['message' => 'Data berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            \Log::error('Update Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui data!'], 500);
        }
    }





    public function show($id)
    {
        $inventoryItem = InventoryItem::find($id);

        if (!$inventoryItem) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($inventoryItem);
    }

    public function destroy($id)
    {
        $inventoryItem = InventoryItem::findOrFail($id);
        $inventoryItem->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }

    public function export()
    {
        return Excel::download(new InventoryExport, 'inventory.xlsx');
    }
}
