<?php

namespace App\Cells;

use App\Models\ArtikelModel;
use CodeIgniter\View\Cells\Cell;

class ArtikelTerkini extends Cell
{
    public function render(): string
    {
        $artikel = (new ArtikelModel())->getLatestPublished(5);

        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}
