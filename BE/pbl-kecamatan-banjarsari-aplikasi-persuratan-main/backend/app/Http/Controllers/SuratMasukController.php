<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use Carbon\Carbon;

class SuratMasukController extends Controller
{
    protected $perPage = 10;

    public function indexapi(Request $request)
    {
        $query = SuratMasuk::query();

        if ($request->has('input')) {
            $order = $request->input('input');
            $this->applyOrder($query, $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $suratMasuk = $query->paginate($this->perPage);

        foreach ($suratMasuk->items() as $surat) {
            $disposisi = Disposisi::where('id_surat_masuk', $surat->id_surat_masuk)->first();
            $surat->disposisi = $disposisi ? $disposisi->toArray() : null;
        }

        return response()->json([
            'data' => $suratMasuk->items(),
            'meta' => [
                'last_page' => $suratMasuk->lastPage(),
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
        $suratMasuk = SuratMasuk::findOrFail($id);
        $disposisi = Disposisi::where('id_surat_masuk', $suratMasuk->id_surat_masuk)->get();
        $suratMasuk->disposisi = $disposisi;
    
        return response()->json($suratMasuk, 200);
    }    

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');
        $results = SuratMasuk::where(function ($query) use ($keywords) {
            $query->where('no_surat', 'like', "%$keywords%")
                ->orWhere('pengirim', 'like', "%$keywords%")
                ->orWhere('perihal', 'like', "%$keywords%");
        })->get();

        return response()->json($results);
    }

    public function storeapi(Request $request)
    {
        $validated = $this->validateRequest($request);

        if ($request->hasFile('file_surat')) {
            $nama_file = $this->storeFile($request->file('file_surat'));

            $suratMasuk = new SuratMasuk($validated);
            $suratMasuk->file_surat = $nama_file;
            $suratMasuk->save();

            return response()->json($suratMasuk, 201);
        }

        return response()->json(['error' => 'File not found.'], 400);
    }

    public function updateapi(Request $request, $id)
    {
        $this->validateMethod($request);

        $validated = $this->validateRequest($request);

        $suratMasuk = SuratMasuk::findOrFail($id);
        $suratMasuk->fill($validated);

        if ($request->hasFile('file_surat')) {
            $this->deleteOldFile($suratMasuk->file_surat);
            $nama_file = $this->storeFile($request->file('file_surat'));
            $suratMasuk->file_surat = $nama_file;
        }

        $suratMasuk->save();

        return response()->json([
            'message' => 'Surat masuk berhasil diperbarui',
            'surat_masuk' => $suratMasuk,
        ], 200);
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'perihal' => 'nullable',
            'no_surat' => 'nullable',
            'sifat_surat' => 'nullable',
            'kode' => 'nullable',
            'tanggal_diterima' => 'required|date',
            'tanggal_agenda' => 'nullable|date',
            'tempat_agenda' => 'nullable',
            'pengirim' => 'required',
            'isi_ringkas' => 'required',
            'file_surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'no_agenda' => 'nullable|integer'
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
        $nama_file = time() . '.' . $file->getClientOriginalName();
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
        $suratMasuk = SuratMasuk::findOrFail($id);
        $filePath = public_path('uploads/' . $suratMasuk->file_surat);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $suratMasuk->file_surat . '"'
        ]);
    }

    public function destroyapi($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        $this->deleteOldFile($suratMasuk->file_surat);
        $suratMasuk->delete();

        return response()->json(['message' => 'Data surat masuk berhasil dihapus.'], 200);
    }

    public function totalsm(Request $request)
    {
        $sm = SuratMasuk::count();
        return response()->json([
            'message' => 'success get data',
            'data' => [
                'total_sm' => $sm
        ]
            ], 200);
    }

    public function smblmterdisposisi(Request $request)
    {
        $count = SuratMasuk::leftJoin('disposisi', 'surat_masuk.id_surat_masuk', '=', 'disposisi.id_surat_masuk')
            ->whereNull('disposisi.id_disposisi')
            ->count();
            return response()->json([
                'message' => 'success get data',
                'data' => [
                    'total' => $count
            ]
                ], 200);
    }

    public function smtoday(Request $request)
    {
        $today = Carbon::today()->toDateString(); 
        $smtd = SuratMasuk::whereDate('created_at', $today)->get();
        if ($smtd->isEmpty()) {
            return response()->json([
                'message' => 'No data found for today',
                'data' => []
            ], 404);
        }
        return response()->json([
            'message' => 'sucess get data',
            'data' => $smtd
            ], 200);
    }

}
