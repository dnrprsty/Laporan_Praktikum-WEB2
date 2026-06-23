<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about(): string
    {
        return view('pages/about', $this->pageData([
            'title' => $this->siteContent->pages['about']['title'],
            'page'  => $this->siteContent->pages['about'],
        ]));
    }

    public function contact(): string
    {
        return view('pages/contact', $this->pageData([
            'title' => $this->siteContent->pages['contact']['title'],
            'page'  => $this->siteContent->pages['contact'],
        ]));
    }
}
