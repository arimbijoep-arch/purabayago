<?php

namespace App\Controllers;

class Category extends BaseController
{
    public function index()
    {
        return view('categories/index', [
            'categories' => [
                [
                    'value' => 'ekonomi',
                    'label' => 'Ekonomi',
                    'eyebrow' => 'Hemat dan praktis',
                    'description' => 'Pilihan perjalanan dengan tarif lebih terjangkau untuk kebutuhan sehari-hari.',
                    'best_for' => 'Cocok untuk perjalanan hemat',
                ],
                [
                    'value' => 'patas',
                    'label' => 'Patas',
                    'eyebrow' => 'Cepat dan nyaman',
                    'description' => 'Pilihan dengan waktu tempuh dan kenyamanan yang lebih baik untuk perjalanan antarkota.',
                    'best_for' => 'Cocok untuk perjalanan rutin',
                ],
                [
                    'value' => 'executive',
                    'label' => 'Executive',
                    'eyebrow' => 'Fasilitas lebih lengkap',
                    'description' => 'Pilihan dengan fasilitas dan ruang yang lebih nyaman untuk perjalanan yang lebih tenang.',
                    'best_for' => 'Cocok untuk perjalanan panjang',
                ],
            ],
        ]);
    }
}