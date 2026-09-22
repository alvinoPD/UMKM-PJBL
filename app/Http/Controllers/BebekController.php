<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BebekController extends Controller
{
    public function index()
    {
        $namaUsaha = "Bebek Protol Super Pedas";
        $menuUtama = "Bebek Protol Sambal Hijau";
        $harga     = "Rp 25.000";

        return view('index', compact('namaUsaha', 'menuUtama', 'harga'));
    }
}