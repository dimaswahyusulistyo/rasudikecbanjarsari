<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk';
    protected $primaryKey = 'id_surat_masuk';

    protected $fillable = [
        'id_kp',
        'no_surat',
        'sifat_surat',
        'kode',
        'tanggal_diterima',
        'tanggal_agenda',
        'tempat_agenda',
        'pengirim',
        'disposisi',
        'perihal',
        'isi_ringkas',
        'file_surat',
        'no_agenda'
    ];
}
