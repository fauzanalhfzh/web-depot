<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PelangganController extends Controller
{
    public function showLoginForm()
    {
        return view('pelanggan.login');
    }

    public function showRegisterForm()
    {
        return view('pelanggan.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('pelanggan')->attempt($credentials)) {
            return redirect()->route('pelanggan.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'kontak_pelanggan' => 'required|string|max:15',
            'email' => 'required|email|unique:pelanggan,email',
            'password' => 'required|min:6',
        ]);

        $pelanggan = Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'kontak_pelanggan' => $request->kontak_pelanggan,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('pelanggan')->login($pelanggan);

        return redirect()->route('pelanggan.dashboard');
    }

    public function index()
    {
        $pelanggan = Auth::guard('pelanggan')->user();
        $totalKupon = $pelanggan->transaksi()->sum('bonus');

        $transaksi = $pelanggan->transaksi()->with('produk')->latest()->get();


        return view('pelanggan.dashboard', compact('pelanggan', 'totalKupon', 'transaksi'));
    }


    public function logout()
    {
        Auth::guard('pelanggan')->logout();
        return redirect()->route('pelanggan.login');
    }
}
