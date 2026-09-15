<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Tentang PURABAYA GO',
        ];

        return view('about/index', $data);
    }
}
