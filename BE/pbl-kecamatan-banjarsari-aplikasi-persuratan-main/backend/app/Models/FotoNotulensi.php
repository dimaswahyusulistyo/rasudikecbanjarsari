<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoNotulensi extends Model
{
    use HasFactory;

    protected $table = 'foto_notulensi';
    protected $primaryKey = 'id_foto_notulensi';

    protected $fillable = [
        'id_disposisi',
        'file_foto',
    ];

    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class, 'id_disposisi');
    }
}

