<?php

namespace App\Observers;

use App\Models\TindakLanjut;

class TindakLanjutObserver
{

    public function created(TindakLanjut $tindakLanjut)
    {
        $this->updateLhpStatus($tindakLanjut);
    }


    public function updated(TindakLanjut $tindakLanjut)
    {
        $this->updateLhpStatus($tindakLanjut);
    }



    private function updateLhpStatus(TindakLanjut $tindakLanjut)
    {

        $rekomendasi = $tindakLanjut->rekomendasi;


        $lhp = $rekomendasi
            ->temuan
            ->lhp;


        $lhp->updateStatusProses();

    }

}
