<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = 'Selamat Datang di Sistem Informasi Desa & PKK';
        
        // Memanggil file view bernama home.php
        return view('home', $data);
    }
}