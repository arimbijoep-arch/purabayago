<?php

namespace App\Controllers;

class Guide extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Panduan Penggunaan',
        ];

        return view('guide/index', $data);
    }
}
