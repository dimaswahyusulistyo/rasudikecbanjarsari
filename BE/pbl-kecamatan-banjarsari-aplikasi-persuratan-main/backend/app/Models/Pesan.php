<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pegawai;

class Pesan extends Model
{
    use HasFactory;

    protected $table = 'pesan';
    protected $primaryKey = 'id_pesan';

    protected $fillable = [
        'id_surat_masuk',
        'perintah_dispo',
        'pendispo'
    ];

    public function surat()
    {
        return $this->belongsTo(Disposisi::class, 'id_surat_masuk');
    }

    public function pengirim()
    {
        return $this->belongsTo(Pegawai::class, 'pendispo');
    }
}
