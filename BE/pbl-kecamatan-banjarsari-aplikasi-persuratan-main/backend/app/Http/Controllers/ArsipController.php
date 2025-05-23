<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;

class ArsipController extends Controller
{
    public function indexapi(Request $request)
    {
        $perPage = $request->has('per_page') ? intval($request->per_page) : 10;

        $query = SuratMasuk::select('id_surat_masuk as id_surat', 'perihal', 'tipe_surat', 'no_surat', 'tanggal_diterima as tanggal_surat')
            ->union(SuratKeluar::select('id_surat_keluar as id_surat', 'perihal', 'tipe_surat', 'no_surat', 'tanggal_keluar as tanggal_surat'));

        if ($request->has('input')) {
            $order = $request->input('input');
            if ($order === 'terbaru') {
                $query->orderBy('tanggal_surat', 'desc');
            } elseif ($order === 'terlama') {
                $query->orderBy('tanggal_surat', 'asc');
            }
        } else {
            $query->orderBy('tanggal_surat', 'desc');
        }

        $arsip = $query->paginate($perPage);

        return response()->json([
            'data' => $arsip->items(),
            'meta' => [
                'last_page' => $arsip->lastPage(),
            ],
        ], 200);
    }

    public function search(Request $request)
    {
        $keywords = $request->input('keywords');

        $querySuratMasuk = SuratMasuk::where(function ($query) use ($keywords) {
            $query->where('no_surat', 'like', "%$keywords%")
                ->orWhere('tipe_surat', 'like', "%$keywords%")
                ->orWhere('perihal', 'like', "%$keywords%");
        })->select('id_surat_masuk as id_surat', 'perihal', 'tipe_surat', 'no_surat', 'tanggal_diterima as tanggal_surat');

        $querySuratKeluar = SuratKeluar::where(function ($query) use ($keywords) {
            $query->where('no_surat', 'like', "%$keywords%")
                ->orWhere('tipe_surat', 'like', "%$keywords%")
                ->orWhere('perihal', 'like', "%$keywords%");
        })->select('id_surat_keluar as id_surat', 'perihal', 'tipe_surat', 'no_surat', 'tanggal_keluar as tanggal_surat');

        $results = $querySuratMasuk
            ->union($querySuratKeluar)
            ->get();

        return response()->json($results);
    }

    public function view($id)
    {
        $surat = SuratMasuk::select('file_surat as file')
            ->where('id_surat_masuk', $id)
            ->union(
                SuratKeluar::select('file_surat as file')
                    ->where('id_surat_keluar', $id)
            )
            ->first();

        if (!$surat) {
            return response()->json(['error' => 'Surat not found.'], 404);
        }

        $filePath = public_path('uploads/' . $surat->file);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found.'], 404);
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }

    public function agendaKeluar(Request $request)
    {
        $currentDateTime = Carbon::now();
        $arsip = SuratMasuk::select(
            'surat_masuk.id_surat_masuk as id_surat',
            'surat_masuk.perihal',
            'surat_masuk.isi_ringkas',
            'surat_masuk.tipe_surat',
            'surat_masuk.no_surat',
            'surat_masuk.tanggal_diterima as tanggal_surat',
            'surat_masuk.tanggal_agenda',
            'surat_masuk.tempat_agenda',
            'disposisi.penerimadispo',
            'disposisi.created_at as disposisi_created_at'
        )
        ->leftJoin('disposisi', 'surat_masuk.id_surat_masuk', '=', 'disposisi.id_surat_masuk')
        ->where('surat_masuk.tipe_surat', 'Surat Masuk')
        ->whereNotNull('surat_masuk.tanggal_agenda')
        ->whereNotNull('disposisi.penerimadispo')
        ->where('surat_masuk.tanggal_agenda', '>=', $currentDateTime)
        ->orderBy('surat_masuk.tanggal_agenda', 'asc')
        ->get();

        $groupedArsip = $arsip->groupBy('id_surat');
        $processedArsip = $groupedArsip->map(function ($group) {
            if ($group->isNotEmpty()) {
                $penerimaDisposisiTerakhir = $group->sortByDesc('disposisi_created_at')->first()->penerimadispo;
                return [
                    'id_surat' => $group->first()->id_surat,
                    'perihal' => $group->first()->perihal,
                    'isi_ringkas' => $group->first()->isi_ringkas,
                    'tipe_surat' => $group->first()->tipe_surat,
                    'no_surat' => $group->first()->no_surat,
                    'tanggal_surat' => $group->first()->tanggal_surat,
                    'tanggal_agenda' => $group->first()->tanggal_agenda,
                    'tempat_agenda' => $group->first()->tempat_agenda,
                    'penerima_disposisi' => $penerimaDisposisiTerakhir
                ];
            }
        });

        $processedArsip = $processedArsip->filter()->take(10);

        if ($processedArsip->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada surat masuk yang memiliki agenda atau disposisi.'
            ], 404);
        }

        return response()->json([
            'data_agenda_keluar' => $processedArsip->values()
        ], 200);
    }


    public function agendaInternal(Request $request)
    {
        $currentDateTime = Carbon::now();

        $arsip = SuratKeluar::select(
            'id_surat_keluar as id_surat', 
            'perihal', 
            'isi_ringkas',
            'tipe_surat', 
            'no_surat', 
            'tanggal_keluar as tanggal_surat', 
            'tanggal_agenda', 
            'tempat_agenda'
        )
        ->where('tipe_surat', 'Surat Keluar')
        ->whereNotNull('tanggal_agenda')
        ->where('tanggal_agenda', '>=', $currentDateTime)
        ->orderBy('tanggal_agenda', 'asc')
        ->get();
        
        $arsip = $arsip->take(10);


        if ($arsip->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada surat keluar yang memiliki agenda.'
            ], 404);
        }

        return response()->json([
            'data_agenda_internal' => $arsip
        ], 200);
    }
}
