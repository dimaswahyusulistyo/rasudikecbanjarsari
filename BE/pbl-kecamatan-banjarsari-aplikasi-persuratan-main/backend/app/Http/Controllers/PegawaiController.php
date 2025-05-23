<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function indexapi(Request $request)
    {
        $paginate = $request->has('paginate') ? filter_var($request->paginate, FILTER_VALIDATE_BOOLEAN) : true;

        $query = Pegawai::query()->with('jabatan');

        if ($request->has('input')) {
            $order = $request->input('input');
            if ($order === 'az') {
                $query->orderBy('nama_pegawai', 'asc');
            } elseif ($order === 'za') {
                $query->orderBy('nama_pegawai', 'desc');
            }
        } else {
            $query->orderBy('nama_pegawai', 'asc');
        }

        if ($paginate) {
            $perPage = $request->has('per_page') ? intval($request->per_page) : 10;
            $pegawai = $query->paginate($perPage);
            return response()->json([
                'data' => $pegawai->items(),
                'meta' => [
                    'last_page' => $pegawai->lastPage(),
                ],
            ], 200);
        } else {

            $pegawai = $query->get();
            return response()->json($pegawai, 200);
        }
    }


    public function showapi($id)
    {
        $pegawai = Pegawai::with('jabatan')->findOrFail($id);
        return response()->json($pegawai, 200);
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');

        $results = Pegawai::where(function ($query) use ($keywords) {
            $query->where('nama_pegawai', 'like', "%$keywords%")
                ->orWhere('nip', 'like', "%$keywords%")
                ->orWhere('email', 'like', "%$keywords%")
                ->orWhereHas('jabatan', function ($query) use ($keywords) {
                    $query->where('nama_jabatan', 'like', "%$keywords%");
                });
        })->get();

        return response()->json($results);
    }

    public function storeapi(Request $request)
    {
        $validated = $request->validate([
            'id_jabatan' => 'required',
            'nama_pegawai' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'file_foto' => 'required|file|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('file_foto')) {
            $file = $request->file('file_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move('foto_pegawai/', $filename);

            $pegawai = new Pegawai;
            $pegawai->id_jabatan = $request->id_jabatan;
            $pegawai->nama_pegawai = $request->nama_pegawai;
            $pegawai->email = $request->email;
            $pegawai->nip = $request->nip;
            $pegawai->file_foto = $filename;

            $pegawai->save();

            return response()->json($pegawai, 201);
        } else {
            return response()->json(['error' => 'File not found.'], 400);
        }
    }

    public function updateapi(Request $request, $id)
    {
        $method = $request->input('_method', 'PUT');
        if (in_array(strtoupper($method), ['PUT', 'PATCH'])) {
            $validated = $request->validate([
                'id_jabatan' => 'required',
                'nama_pegawai' => 'required',
                'email' => 'email',
                'nip' => 'required',
                'file_foto' => 'nullable|file|mimes:jpg,jpeg,png'
            ]);

            $pegawai = Pegawai::findOrFail($id);
            $pegawai->id_jabatan = $request->id_jabatan;
            $pegawai->nama_pegawai = $request->nama_pegawai;
            $pegawai->email = $request->email;
            $pegawai->nip = $request->nip;

            if ($request->hasFile('file_foto')) {
                if ($pegawai->file_foto) {
                    $filePath = 'foto_pegawai/' . $pegawai->file_foto;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
                $file = $request->file('file_foto');
                $nama_file = time() . '_' . $file->getClientOriginalName();
                $file->move('foto_pegawai', $nama_file);
                $pegawai->file_foto = $nama_file;
            }

            $pegawai->save();

            return response()->json([
                'message' => 'Pegawai berhasil diperbarui',
                'pegawai' => $pegawai,
            ], 200);
        } else {

            return response()->json([
                'error' => 'Metode HTTP tidak diizinkan',
            ], 405);
        }
    }

    public function destroyapi($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return response()->json(['message' => 'Data pegawai berhasil dihapus.'], 200);
    }

    public function getPegawaiForDisposisi()
    {
        $user = Auth::user();
        $pegawai = Pegawai::with('jabatan')->findOrFail($user->id_pegawai);
        $jabatanPegawai = Jabatan::findOrFail($pegawai->id_jabatan);
        $tierPegawai = $jabatanPegawai->tier;

        $pegawaiBawahTier = Pegawai::with('jabatan')->whereHas('jabatan', function ($query) use ($tierPegawai) {
            $query->whereHas('tier', function ($query) use ($tierPegawai) {
                $query->where('tier_level', '>', $tierPegawai->tier_level);
            });
        })->get();

        if ($user->role == 'camat') {
            $pegawaiBawahTier->prepend($pegawai);
        }

        return response()->json([
            'data' => $pegawaiBawahTier,
        ], 200);
    }



    public function totalpgw(Request $request)
    {
        $pgw = Pegawai::count();
        return response()->json([
            'message' => 'success get data',
            'data' => [
                'total_pgw' => $pgw
            ]
        ], 200);
    }
}
