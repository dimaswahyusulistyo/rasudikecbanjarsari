<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\KategoriPerihal;

class KategoriPerihalController extends Controller
{
    public function indexapi()
    {
        $kategoriPerihals = KategoriPerihal::all();
        return response()->json($kategoriPerihals, 200);
    }

    public function showapi($id)
    {
        $kategoriPerihal = KategoriPerihal::findOrFail($id);
        return response()->json($kategoriPerihal, 200);
    }

    public function storeapi(Request $request)
    {
        $validated = $request->validate([
            'perihal' => 'required',
        ]);

        $kategoriPerihal = new KategoriPerihal;
        $kategoriPerihal->perihal = $request->perihal;
        $kategoriPerihal->save();

        return response()->json($kategoriPerihal, 201);
    }

    public function updateapi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'perihal' => 'required',
        ]);

        $kategoriPerihal = KategoriPerihal::findOrFail($id);
        $kategoriPerihal->perihal = $validatedData['perihal'];
        $kategoriPerihal->save();

        return response()->json([
            'message' => 'Kategori perihal updated successfully',
            'perihal' => $kategoriPerihal,
        ], 200);
    }

    public function destroyapi($id)
    {
        $kategoriPerihal = KategoriPerihal::findOrFail($id);
        $kategoriPerihal->delete();

        return response()->json(['message' => 'Data kategori perihal berhasil dihapus.'], 200);
    }
}
