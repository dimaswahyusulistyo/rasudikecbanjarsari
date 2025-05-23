<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table      = 'pegawai';
    protected $primaryKey = 'id_pegawai';
    
    protected $fillable = [
        'id_jabatan',
        'nama_pegawai',
        'email',
        'nip',
        'file_foto'
    ];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
