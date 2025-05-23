<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pesan;
use App\Models\Pegawai;

class PesanController extends Controller
{
    public function indexapi()
    {
        $pesan = Pesan::with('surat')->get();
        return response()->json($pesan);
    }

    public function showapi($id)
    {
        $pesan = Pesan::with(['surat'])->findOrFail($id);
        return response()->json($pesan, 200);
    }

    public function storeapi(Request $request)
    {
        $validated = $request->validate([
            'id_surat_masuk' => 'required|exists:surat_masuk,id_surat_masuk',
            'perintah_dispo' => 'required|string'
        ]);

        $user = Auth::user();
        $pengirim = Pegawai::findOrFail($user->id_pegawai);
        $pengirimNama = $pengirim->nama_pegawai;
        $pesan = Pesan::create([
            'id_surat_masuk' => $validated['id_surat_masuk'],
            'perintah_dispo' => $validated['perintah_dispo'],
            'pendispo' => $pengirimNama
        ]);
        return response()->json([
            'message' => 'Pesan berhasil ditambahkan',
            'pesan' => $pesan
        ], 201);
    }

    public function updateapi(Request $request, $id)
    {
        $validated = $request->validate([
            'id_surat_masuk' => 'sometimes|required|exists:surat_masuk,id_surat_masuk',
            'perintah_dispo' => 'sometimes|required|string'
        ]);

        $user = Auth::user();
        $pengirim = Pegawai::findOrFail($user->id_pegawai);
        $pengirimNama = $pengirim->nama_pegawai;

        $pesan = Pesan::findOrFail($id);

        if ($request->has('perintah_dispo')) {
            $validated['pendispo'] = $pengirimNama;
        }

        $pesan->update($validated);

        return response()->json([
            'message' => 'Pesan berhasil diperbarui',
            'pesan' => $pesan
        ], 200);
    }


    public function destroyapi($id)
    {
        $pesan = Pesan::findOrFail($id);
        $pesan->delete();
        return response()->json(['message' => 'Pesan berhasil dihapus'], 200);
    }
}
