<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FotoNotulensi;
use App\Models\Disposisi;
use Illuminate\Support\Facades\Storage;

class FotoNotulensiController extends Controller
{

    public function getFotosByDisposisiId($id_disposisi)
    {
        $fotoNotulensi = FotoNotulensi::where('id_disposisi', $id_disposisi)->get();
        return response()->json($fotoNotulensi);
    }    

    public function indexapi()
    {
        $fotoNotulensi = FotoNotulensi::with('disposisi')->get();
        return response()->json($fotoNotulensi);
    }

    public function showapi($id)
    {
        $fotoNotulensi = FotoNotulensi::with(['disposisi'])->findOrFail($id);
        return response()->json($fotoNotulensi, 200);
    }

    public function storeapi(Request $request)
    {
        $validated = $request->validate([
            'id_disposisi' => 'required|exists:disposisi,id_disposisi',
            'file_foto.*' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        $uploadedFiles = [];

        foreach ($request->file('file_foto') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('foto_notulensi/', $filename);

            $fotoNotulensi = new FotoNotulensi;
            $fotoNotulensi->id_disposisi = $validated['id_disposisi'];
            $fotoNotulensi->file_foto = $filename;
            $fotoNotulensi->save();

            $uploadedFiles[] = $fotoNotulensi;
        }

        return response()->json([
            'message' => 'Foto notulensi berhasil diunggah',
            'fotoNotulensi' => $uploadedFiles,
        ], 201);
    }

    public function updateapi(Request $request, $id)
    {
        $validated = $request->validate([
            'file_foto.*' => 'nullable|file|mimes:jpg,jpeg,png', 
        ]);

        $fotoNotulensi = FotoNotulensi::findOrFail($id);

        foreach ($request->file('file_foto', []) as $file) {
            if ($fotoNotulensi->file_foto) {
                $filePath = 'foto_notulensi/' . $fotoNotulensi->file_foto;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('foto_notulensi', $filename);
            $fotoNotulensi->file_foto = $filename;
        }

        $fotoNotulensi->save();

        return response()->json([
            'message' => 'Foto notulensi berhasil diperbarui',
            'fotoNotulensi' => $fotoNotulensi,
        ], 200);
    }

    public function destroyapi($id)
    {
        $fotoNotulensi = FotoNotulensi::findOrFail($id);
        if ($fotoNotulensi->file_foto) {
            Storage::disk('public')->delete($fotoNotulensi->file_foto);
        }
        $fotoNotulensi->delete();

        return response()->json(['message' => 'Foto notulensi berhasil dihapus.'], 200);
    }
    
    public function downloadFoto($id)
    {
        $fotoNotulensi = FotoNotulensi::findOrFail($id);
        $filePath = public_path('foto_notulensi/') . $fotoNotulensi->file_foto;
    
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    
        return response()->json(['message' => 'File not found.'], 404);
    }    
    
}
