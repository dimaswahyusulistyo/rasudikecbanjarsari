<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';
    protected $primaryKey = 'id_surat_keluar';
    
    protected $fillable = [
        'id_kp',
        'no_surat',
        'tanggal_keluar',
        'tertuju_kepada',
        'tempat_agenda',
        'tanggal_agenda',
        'perihal',
        'isi_ringkas',
        'file_surat',
        'perihal_lainnya',
    ];

}