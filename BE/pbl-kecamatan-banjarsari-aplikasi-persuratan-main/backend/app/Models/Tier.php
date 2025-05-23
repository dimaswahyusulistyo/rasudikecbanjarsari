<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $table = 'tiers';
    protected $primaryKey = 'id_tier';

    protected $fillable = [
        'tier_name',
        'tier_level'
    ];

    public function jabatans()
    {
        return $this->hasMany(Jabatan::class, 'id_tier');
    }

    public function canDisposisiTo(Tier $tier)
    {
        if ($this->tier_level == 1) {
            return true;
        } elseif ($this->tier_level == 3) {
            return false;
        } else {
            return $this->tier_level < $tier->tier_level;
        }
    }


}
