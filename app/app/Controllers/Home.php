<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Home extends BaseController
{
    public function index(): string
    {
        $artikelModel = new ArtikelModel();

        return view('pages/home', $this->pageData([
            'title'            => $this->siteContent->pages['home']['title'],
            'page'             => $this->siteContent->pages['home'],
            'featuredArticles' => $artikelModel->getLatestPublished(3),
        ]));
    }
}
