<?php

namespace App\Observers;

use App\Models\SuratMasuk;

class SuratMasukObserver
{
    public function saving(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->tanggal_agenda && is_null($suratMasuk->no_agenda)) {
            $maxNoAgenda = SuratMasuk::whereNotNull('no_agenda')->max('no_agenda');
            $suratMasuk->no_agenda = $maxNoAgenda + 1;
        }
    }
}
