<?php

namespace App\Http\Controllers;

use App\Models\DataMobil;
use App\Models\DataPeminjaman;
use App\Models\MetodePembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();
        return view('dashboard', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getDataMobil()
    {
        $data = DataMobil::orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Mobil',
            'data' => $data
        ]);
    }

    public function getMetodePembayaran(){
        $data = MetodePembayaran::orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Metode Pembayaran',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $exists = User::where('email', $email)->exists();

        $message = $exists ? 'Email telah digunakan' : 'Email bisa digunakan';

        return response()->json([
            'success' => true,
            'exists' => $exists,
            'message' => $message
        ]);
    }

    public function checkSim(Request $request)
    {
        $nomor_sim = $request->nomor_sim;
        $exists = User::where('nomor_sim', $nomor_sim)->exists();

        $message = $exists ? 'Nomor SIM telah digunakan' : 'Nomor SIM bisa digunakan';

        return response()->json([
            'success' => true,
            'exists' => $exists,
            'message' => $message
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function cekTanggalPeminjaman(Request $request)
    {
        $mobil_id = $request->mobil_id;
        $tanggal_peminjaman = $request->tanggal_peminjaman;
        $tanggal_pengembalian = $request->tanggal_pengembalian;

        // Validasi awal: Pastikan tanggal pengembalian lebih lambat dari tanggal peminjaman
        if (strtotime($tanggal_pengembalian) <= strtotime($tanggal_peminjaman)) {
            return response()->json([
                'success' => true,
                'jadwal' => 'invalid',
                'message' => 'Tanggal pengembalian tidak benar.'
            ], 200);
        }

        // Query untuk mengecek apakah ada peminjaman lain yang bertabrakan
        $overlapping = DB::table('data_peminjamans')
            ->where('mobil_id', $mobil_id)
            ->where(function ($query) use ($tanggal_peminjaman, $tanggal_pengembalian) {
                $query->whereBetween('tanggal_peminjaman', [$tanggal_peminjaman, $tanggal_pengembalian])
                    ->orWhereBetween('tanggal_pengembalian', [$tanggal_peminjaman, $tanggal_pengembalian])
                    ->orWhere(function ($q) use ($tanggal_peminjaman, $tanggal_pengembalian) {
                        $q->where('tanggal_peminjaman', '<=', $tanggal_peminjaman)
                            ->where('tanggal_pengembalian', '>=', $tanggal_pengembalian);
                    });
            })
            ->exists();

        $jadwal = $overlapping ? 'invalid' : 'valid';
        $message = $overlapping ? 'Tanggal peminjaman bertabrakan dengan jadwal lain.' : 'Tanggal tersedia untuk peminjaman.';

        return response()->json([
            'success' => true,
            'jadwal' => $jadwal,
            'message' => $message
        ], 200);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function getDataPinjamanku(string $userId)
    {
        $user = User::where('id', $userId)->first();
        $pinjaman = DataPeminjaman::where('peminjam_id', $user->id)->where('status_mobil', '!=', 'Dikembalikan')->with(['mobil', 'metode_pembayaran', 'peminjam'])->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pinjaman user',
            'data' => $pinjaman
        ]);
    }

    public function getDataPengembalianku(string $userId)
    {
        $user = User::where('id', $userId)->first();
        $data = DataPeminjaman::where('peminjam_id', $user->id)->where('status_pembayaran', 'Paid')->where('status_verifikasi', 'Verified')->where('status_mobil', 'Dikembalikan')->with(['mobil', 'metode_pembayaran', 'peminjam'])->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data pinjaman user',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function getAllPinjaman()
    {
        $data = DataPeminjaman::where('status_pembayaran', 'Paid')->where('status_verifikasi', 'Verified')->get();

        return response()->json([
            'success' => true,
            'message' => 'All Data Peminjaman',
            'data' => $data
        ]);
    }

    public function getPinjaman()
    {
        $data = DataPeminjaman::where('status_mobil', '!=', 'Dikembalikan')->with(['mobil', 'metode_pembayaran', 'peminjam'])->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'All Data Peminjaman',
            'data' => $data
        ]);
    }

    public function getPengembalian()
    {
        $data = DataPeminjaman::where('status_pembayaran', 'Paid')->where('status_verifikasi', 'Verified')->where('status_mobil', 'Dikembalikan')->with(['mobil', 'metode_pembayaran', 'peminjam'])->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'All Data Pengembalian',
            'data' => $data
        ]);
    }
}
