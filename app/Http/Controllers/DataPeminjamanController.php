<?php

namespace App\Http\Controllers;

use App\Models\DataMobil;
use App\Models\DataPeminjaman;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DataPeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dataMobil()
    {
        $data = DataMobil::orderBy('created_at', 'desc')->get();

        return view('pinjaman.mobil', compact('data'));
    }

    public function allCalendarJadwal()
    {
        $mobils = DataMobil::orderBy('created_at', 'desc')->get();
        $data = DataPeminjaman::where('status_pembayaran', 'Paid')->where('status_verifikasi', 'Verified')->with(['mobil'])->get();

        return view('pinjaman.calendar', compact('mobils', 'data'));
    }

    public function modalTambahSewa(Request $request)
    {
        $title = 'Ajukan Sewa';
        $mobil = DataMobil::where('id', $request->id)->first();
        $metodes = MetodePembayaran::orderBy('created_at', 'asc')->get();

        return view('pinjaman.modal-tambah', compact('title', 'metodes', 'mobil'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DataPeminjaman::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ajukan peminjaman'
        ]);
    }

    public function updateStatusMobil(Request $request, string $id)
    {
        $data = DataPeminjaman::find($id);
        $data->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil update status mobil'
        ]);
    }

    public function updateStatusBayar(Request $request, string $id)
    {
        $data = DataPeminjaman::find($id);
        $data->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil update status bayar'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function peminjamanAdmin(Request $request)
    {
        $user = $request->user();

        return view('pinjaman.data', compact('user'));
    }

    public function peminjaman(Request $request)
    {
        $user = $request->user();

        return view('pinjaman.data', compact('user'));
    }

    public function pengembalian(Request $request)
    {
        $user = $request->user();

        return view('pengembalian.data', compact('user'));
    }

    public function pengembalianAdmin(Request $request)
    {
        $user = $request->user();

        return view('pengembalian.data', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function modalBayarSewa(string $peminjamanId)
    {
        $data = DataPeminjaman::where('id', $peminjamanId)->with(['peminjam', 'mobil', 'metode_pembayaran'])->first();
        $title = 'Bayar Sewa Unit';
        $metodes = MetodePembayaran::orderBy('created_at', 'asc')->get();

        return view('pinjaman.modal-bayar', compact('data', 'title', 'metodes'));
    }

    public function modalStatusMobil(string $peminjamanId)
    {
        $data = DataPeminjaman::where('id', $peminjamanId)->with(['peminjam', 'mobil', 'metode_pembayaran'])->first();
        $title = 'Status Mobil Peminjaman';

        return view('pinjaman.modal-status-mobil', compact('data', 'title'));
    }

    public function modalStatusBayar(string $peminjamanId)
    {
        $data = DataPeminjaman::where('id', $peminjamanId)->with(['peminjam', 'mobil', 'metode_pembayaran'])->first();
        $title = 'Status Pembayaran Peminjaman';

        return view('pinjaman.modal-status-bayar', compact('data', 'title'));
    }

    public function modalHapusPeminjaman(string $peminjamanId)
    {
        $data = DataPeminjaman::where('id', $peminjamanId)->with(['peminjam', 'mobil', 'metode_pembayaran'])->first();
        $title = 'Hapus Data Peminjaman';

        return view('pinjaman.modal-hapus', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBayar(Request $request, string $id)
    {
        $data = DataPeminjaman::find($id);
        
        if ($request->hasFile('bukti_pembayaran')) {
            File::delete(public_path('website-resource/bukti-pembayaran/' . $data->bukti_pembayaran));

            $file = $request->file('bukti_pembayaran');
            $imgName = 'Peminjaman-' . date('Ymdhis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('website-resource/bukti-pembayaran/'), $imgName);
        }

        $data->update([
            'metode_pembayaran_id' => $request->metode_pembayaran_id,
            'status_pembayaran' => 'Paid',
            'bukti_pembayaran' => $imgName ?? DB::raw('bukti_pembayaran')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil update pinjaman'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function hapusPeminjaman(string $id)
    {
        $data = DataPeminjaman::find($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data'
        ]);
    }
}
