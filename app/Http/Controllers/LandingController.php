<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiKelurahan;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil 3 informasi terbaru untuk ditampilkan di homepage
        $informasi = InformasiKelurahan::orderBy('created_at', 'desc')
                                     ->limit(3)
                                     ->get();
        
        return view('welcome', compact('informasi'));
    }
}
