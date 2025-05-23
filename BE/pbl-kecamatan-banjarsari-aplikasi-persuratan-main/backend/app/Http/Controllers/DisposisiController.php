<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposisi;
use App\Models\Pegawai;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DisposisiController extends Controller
{
  protected $perPage = 10;

  public function indexapi(Request $request)
  {
    $paginate = $request->has('paginate') ? filter_var($request->paginate, FILTER_VALIDATE_BOOLEAN) : true;

    $query = Disposisi::with(['pengirim', 'penerima', 'surat']);

    if ($request->has('input')) {
      $order = $request->input('input');
      if ($order === 'harian') {
          $query->whereDate('created_at', now()->toDateString())
                ->orderBy('created_at', 'desc');
      } else {
          $query->orderBy('created_at', 'desc');
      }
  }

    if ($paginate) {
      $perPage = $request->has('per_page') ? intval($request->per_page) : 10;
      $disposisi = $query->paginate($perPage);
      return response()->json([
        'data' => $disposisi->items(),
        'meta' => [
          'last_page' => $disposisi->lastPage(),
        ],
      ], 200);
    } else {
      $disposisi = $query->get();
      return response()->json($disposisi, 200);
    }
  }

  public function showapi($id)
  {
    $user = Auth::user();
    $disposisi = Disposisi::with(['surat'])->findOrFail($id);
    return response()->json($disposisi, 200);
  }

  public function search(Request $request)
  {
      $user = Auth::user();
      $pegawai = Pegawai::findOrFail($user->id_pegawai);
      $keywords = $request->input('keywords');

      $results = Disposisi::with(['pengirim', 'penerima', 'surat'])
                            ->where(function ($query) use ($pegawai, $keywords) {
                                $query->where('pendispo', 'like', '%'.$keywords.'%');
                            })
                      ->where('penerimadispo', $pegawai->nama_pegawai)
                      ->get();

      return response()->json($results);
  }


  public function storeapi(Request $request)
  {
    $validated = $request->validate([
      'id_surat_masuk' => 'required|exists:surat_masuk,id_surat_masuk',
      'disposisiList' => 'required|array|min:1',
      'disposisiList.*.penerimadispo' => 'required|exists:pegawai,nama_pegawai',
      'status_pegawai' => 'required|string|max:255',
      'notulensi' => 'nullable|string',
    ]);

    $user = Auth::user();
    $pengirim = Pegawai::findOrFail($user->id_pegawai);
    $pengirimNama = $pengirim->nama_pegawai;

    $jabatanPengirim = Jabatan::findOrFail($pengirim->id_jabatan);
    $tierPengirim = $jabatanPengirim->tier;

    $disposisiCreated = [];
    foreach ($validated['disposisiList'] as $dispo) {
      $penerima = Pegawai::where('nama_pegawai', $dispo['penerimadispo'])->firstOrFail();
      $jabatanPenerima = Jabatan::findOrFail($penerima->id_jabatan);
      $tierPenerima = $jabatanPenerima->tier;

      if (!$tierPengirim->canDisposisiTo($tierPenerima)) {
        return response()->json(['error' => 'Anda tidak memiliki wewenang untuk mendisposisi ke pegawai dengan jabatan lebih tinggi atau sama.'], 403);
      }

      $disposisi = Disposisi::create([
        'id_surat_masuk' => $validated['id_surat_masuk'],
        'pendispo' => $pengirimNama,
        'penerimadispo' => $dispo['penerimadispo'],
        'status_pegawai' => $validated['status_pegawai'],
        'notulensi' => $validated['notulensi'] ?? null,
      ]);

      $disposisiCreated[] = $disposisi;
    }

    return response()->json([
      'message' => 'Disposisi berhasil disimpan',
      'disposisi' => $disposisiCreated
    ], 201);
  }

  public function updateapi(Request $request, $id)
  {
    $validated = $request->validate([
      'id_surat_masuk' => 'required|exists:surat_masuk,id_surat_masuk',
      'penerimadispo' => 'required|exists:pegawai,nama_pegawai',
      'status_pegawai' => 'nullable|string|max:255',
      'notulensi' => 'nullable|string',
    ]);

    $user = Auth::user();
    $pengirim = Pegawai::findOrFail($user->id_pegawai);
    $pengirimNama = $pengirim->nama_pegawai;

    $penerima = Pegawai::where('nama_pegawai', $validated['penerimadispo'])->firstOrFail();

    $jabatanPengirim = Jabatan::findOrFail($pengirim->id_jabatan);
    $jabatanPenerima = Jabatan::findOrFail($penerima->id_jabatan);

    $tierPengirim = $jabatanPengirim->tier;
    $tierPenerima = $jabatanPenerima->tier;

    if (!$tierPengirim->canDisposisiTo($tierPenerima)) {
      return response()->json([
        'error' => 'Anda tidak memiliki wewenang untuk mendisposisi ke pegawai dengan jabatan lebih tinggi atau sama.',
      ], 403);
    }

    $disposisi = Disposisi::findOrFail($id);
    $disposisi->id_surat_masuk = $validated['id_surat_masuk'];
    $disposisi->pendispo = $pengirimNama;
    $disposisi->penerimadispo = $validated['penerimadispo'];
    $disposisi->status_pegawai = $validated['status_pegawai'] ?? $disposisi->status_pegawai;
    $disposisi->notulensi = $validated['notulensi'] ?? $disposisi->notulensi;
    $disposisi->save();

    return response()->json([
      'message' => 'Disposisi berhasil diperbarui',
      'disposisi' => $disposisi,
    ], 200);
  }


  public function destroyapi($id)
  {
    $disposisi = Disposisi::findOrFail($id);
    $disposisi->delete();

    return response()->json(['message' => 'Data disposisi berhasil dihapus.'], 200);
  }

  public function cekDisposisiSaya(Request $request)
  {
      $user = Auth::user();
      $pegawai = Pegawai::findOrFail($user->id_pegawai);
      
      $query = Disposisi::with(['pengirim', 'penerima', 'surat'])
          ->where('penerimadispo', $pegawai->nama_pegawai)
          ->orderBy('created_at', 'desc');

      if ($request->has('input')) {
          $order = $request->input('input');
          if ($order === 'harian') {
              $query->whereDate('created_at', now()->toDateString());
          }
      }

      $disposisi = $query->paginate($this->perPage);

      return response()->json([
          'data' => $disposisi->items(),
          'meta' => [
              'last_page' => $disposisi->lastPage(),
          ],
      ], 200);
  }


  public function getTotalDisposisiSaya()
  {
    $user = Auth::user();
    $pegawai = Pegawai::findOrFail($user->id_pegawai);
    $totalDispo = Disposisi::where('penerimadispo', $pegawai->nama_pegawai)->count();

    return response()->json([
      'data' => [
        'total_dispo' => $totalDispo
      ]
    ], 200);
  }

  public function updateNotulensi(Request $request, $id)
  {
      $validated = $request->validate([
          'notulensi' => 'nullable|string',
      ]);

      $user = Auth::user();
      $pengirim = Pegawai::findOrFail($user->id_pegawai);
      $pengirimNama = $pengirim->nama_pegawai;

      $disposisi = Disposisi::findOrFail($id);
      $disposisi->notulensi = $validated['notulensi'] ?? null;
      $disposisi->save();

      return response()->json([
          'message' => 'Notulensi berhasil diperbarui',
          'disposisi' => $disposisi,
      ], 200);
  }
}
