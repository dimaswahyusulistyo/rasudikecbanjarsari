<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    protected $perPage = 10;

    public function indexapi(Request $request)
    {
        $paginate = $request->has('paginate') ? filter_var($request->paginate, FILTER_VALIDATE_BOOLEAN) : true;

        $query = Jabatan::query();

        if ($request->has('input')) {
            $order = $request->input('input');
            if ($order === 'az') {
                $query->orderBy('nama_jabatan', 'asc');
            } elseif ($order === 'za') {
                $query->orderBy('nama_jabatan', 'desc');
            }
        } else {
            $query->orderBy('nama_jabatan', 'asc');
        }

        if ($paginate) {
            $perPage = $request->has('per_page') ? intval($request->per_page) : 10;
            $jabatan = $query->paginate($perPage);
            return response()->json([
                'data' => $jabatan->items(),
                'meta' => [
                    'last_page' => $jabatan->lastPage(),
                ],
            ], 200);
        } else {
            $jabatan = $query->get();
            return response()->json($jabatan, 200);
        }
    }

    public function indexnotier(Request $request)
    {
        $paginate = $request->has('paginate') ? filter_var($request->paginate, FILTER_VALIDATE_BOOLEAN) : true;

        $query = Jabatan::whereNull('id_tier'); // Only get Jabatan entries without a Tier

        if ($request->has('input')) {
            $order = $request->input('input');
            if ($order === 'az') {
                $query->orderBy('nama_jabatan', 'asc');
            } elseif ($order === 'za') {
                $query->orderBy('nama_jabatan', 'desc');
            }
        } else {
            $query->orderBy('nama_jabatan', 'asc');
        }

        if ($paginate) {
            $perPage = $request->has('per_page') ? intval($request->per_page) : 10;
            $jabatan = $query->paginate($perPage);
            return response()->json([
                'data' => $jabatan->items(),
                'meta' => [
                    'last_page' => $jabatan->lastPage(),
                ],
            ], 200);
        } else {
            $jabatan = $query->get();
            return response()->json($jabatan, 200);
        }
    }

    public function showapi($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return response()->json($jabatan, 200);
    }

    public function storeapi(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'id_tier' => 'required|exists:tiers,id_tier'
        ]);

        $jabatan = new Jabatan;
        $jabatan->nama_jabatan = $validated['nama_jabatan'];
        $jabatan->id_tier = $validated['id_tier'];
        $jabatan->save();

        return response()->json([
            'message' => 'Data Jabatan Berhasil Disimpan',
            'jabatan' => $jabatan
        ], 201);
    }

    public function updateapi(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'id_tier' => 'required|exists:tiers,id_tier'
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->nama_jabatan = $validatedData['nama_jabatan'];
        $jabatan->id_tier = $validatedData['id_tier'];
        $jabatan->save();

        return response()->json([
            'message' => 'Jabatan updated successfully',
            'jabatan' => $jabatan,
        ], 200);
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');

        $results = Jabatan::where('nama_jabatan', 'like', "%$keywords%")->get();

        return response()->json($results);
    }

    public function destroyapi($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return response()->json(['message' => 'Data Jabatan berhasil dihapus.'], 200);
    }

    public function removetier($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->id_tier = null;
        $jabatan->save();
        return response()->json(['message' => 'Tiers pada Jabatan berhasil dihapus.'], 200);
    }
}
