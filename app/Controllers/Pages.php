<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'HOME | My Inventory',
            'tes' => ['satu', 'dua', 'tiga']
        ];
        return view('pages/home', $data);
    }
    public function about()
    {
        $data = [
            'title' => 'Tentang Kami'
        ];
        return view('pages/about', $data);
    }
    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'alamat' => [
                [
                    'tipe' => 'rumah',
                    'alamat' => 'Jl. Mentimun III No.09',
                    'kota' => 'Bekasi'
                ],
                [
                    'tipe' => ' kantor',
                    'alamat' => 'Jl. lalala No.90',
                    'kota' => ' Tangerang'
                ]
            ]
        ];

        return view('pages/contact', $data);
    }
}
