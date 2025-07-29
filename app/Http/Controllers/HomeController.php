<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $produks = Produk::all(); // ambil semua produk
        return view('welcome', compact('produks'));
    }
}
