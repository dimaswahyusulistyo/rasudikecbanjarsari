<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKeluar;

class SuratKeluarController extends Controller
{
    protected $perPage = 10;

    public function indexapi(Request $request)
    {
        $query = SuratKeluar::query();

        if ($request->has('input')) {
            $order = $request->input('input');
            $this->applyOrder($query, $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $suratKeluar = $query->paginate($this->perPage);

        return response()->json([
            'data' => $suratKeluar->items(),
            'meta' => [
                'last_page' => $suratKeluar->lastPage(),
            ],
        ], 200);
    }

    private function applyOrder($query, $order)
    {
        switch ($order) {
            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            case 'harian':
                $query->whereDate('created_at', now()->toDateString())
                    ->orderBy('created_at', 'desc');
                break;
            case 'mingguan':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->orderByRaw('YEAR(created_at) DESC, WEEK(created_at) DESC');
                break;
            case 'bulanan':
                $query->whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month)
                    ->orderByRaw('YEAR(created_at) DESC, MONTH(created_at) DESC');
                break;
            case 'tahunan':
                $query->whereYear('created_at', now()->year)
                    ->orderByRaw('YEAR(created_at) DESC');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    public function showapi($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        return response()->json($suratKeluar, 200);
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');
        $results = SuratKeluar::where(function ($query) use ($keywords) {
            $query->where('no_surat', 'like', "%$keywords%")
                ->orWhere('tertuju_kepada', 'like', "%$keywords%")
                ->orWhere('perihal', 'like', "%$keywords%");
        })->get();

        return response()->json($results);
    }

    public function storeapi(Request $request)
    {
        $validated = $this->validateRequest($request);

        if ($request->hasFile('file_surat')) {
            $nama_file = $this->storeFile($request->file('file_surat'));

            $suratKeluar = new SuratKeluar($validated);
            $suratKeluar->file_surat = $nama_file;
            $suratKeluar->save();

            return response()->json($suratKeluar, 201);
        }

        return response()->json(['error' => 'File not found.'], 400);
    }

    public function updateapi(Request $request, $id)
    {
        $this->validateMethod($request);

        $validated = $this->validateRequest($request);

        $suratKeluar = SuratKeluar::findOrFail($id);
        $suratKeluar->fill($validated);

        if ($request->hasFile('file_surat')) {
            $this->deleteOldFile($suratKeluar->file_surat);
            $nama_file = $this->storeFile($request->file('file_surat'));
            $suratKeluar->file_surat = $nama_file;
        }

        $suratKeluar->save();

        return response()->json([
            'message' => 'Surat keluar berhasil diperbarui',
            'surat_keluar' => $suratKeluar,
        ], 200);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'no_surat' => 'nullable',
            'tanggal_keluar' => 'required|date',
            'tertuju_kepada' => 'required',
            'perihal' => 'required',
            'tempat_agenda' => 'nullable',
            'tanggal_agenda' => 'nullable|date',
            'isi_ringkas' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);
    }

    private function validateMethod(Request $request)
    {
        $method = $request->input('_method', 'PUT');
        if (!in_array(strtoupper($method), ['PUT', 'PATCH'])) {
            return response()->json(['error' => 'Metode HTTP tidak diizinkan'], 405);
        }
    }

    private function storeFile($file)
    {
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file->move('uploads/', $nama_file);
        return $nama_file;
    }

    private function deleteOldFile($fileName)
    {
        $filePath = public_path('uploads/' . $fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function view($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        $filePath = public_path('uploads/' . $suratKeluar->file_surat);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $suratKeluar->file_surat . '"'
        ]);
    }

    public function destroyapi($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        $this->deleteOldFile($suratKeluar->file_surat);
        $suratKeluar->delete();

        return response()->json(['message' => 'Data surat keluar berhasil dihapus.'], 200);
    }

    public function totalsk(Request $request)
    {
        $sk = SuratKeluar::count();
        return response()->json([
            'message' => 'success get data',
            'data' => [
                'total_sk' => $sk
        ]
            ], 200);
    }
}
