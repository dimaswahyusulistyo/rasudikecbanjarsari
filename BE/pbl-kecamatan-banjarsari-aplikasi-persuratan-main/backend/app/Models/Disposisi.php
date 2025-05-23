<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';
    protected $primaryKey = 'id_disposisi';

    protected $fillable = [
        'id_surat_masuk',
        'pendispo',
        'penerimadispo',
        'tanggal_disposisi',
        'status_pegawai',
        'notulensi'
    ];

    public function surat()
    {
        return $this->belongsTo(SuratMasuk::class, 'id_surat_masuk');
    }

    public function pengirim()
    {
        return $this->belongsTo(Pegawai::class, 'pendispo');
    }

    public function penerima()
    {
        return $this->belongsTo(Pegawai::class, 'penerimadispo');
    }
}
