<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPerihal extends Model
{
    use HasFactory;

    protected $table      = 'kategori_perihal';
    protected $primaryKey = 'id_kp';
    
    protected $fillable = [
        'perihal'
    ];
}
