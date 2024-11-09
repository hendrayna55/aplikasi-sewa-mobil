<?php

namespace App\Http\Controllers;

use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MetodePembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = MetodePembayaran::orderBy('created_at', 'desc')->get();
        return view('metode-pembayaran.index', compact('data'));
    }

    public function modalTambahMetode()
    {
        $title = "Tambah Metode";
        $banks = File::json(public_path('website-resource/bank_indonesia_edit.json'));

        return view('metode-pembayaran.modal-tambah', compact('title', 'banks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $logo_metode = strtolower($request->logo_metode) . '.svg';
        $data['logo_metode'] = $logo_metode;
        
        MetodePembayaran::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil tambah metode',
        ]);
    }

    /**
     * Display the specified resource.
     */
    
    public function modalEditMetode(string $id)
    {
        $data = MetodePembayaran::find($id);
        $banks = File::json(public_path('website-resource/bank_indonesia_edit.json'));
        $title = 'Edit Metode';

        return view('metode-pembayaran.modal-edit', compact('title', 'banks', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $logo_metode = strtolower($request->logo_metode) . '.svg';
        $data['logo_metode'] = $logo_metode;
        
        MetodePembayaran::find($id)->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil update metode',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function modalHapusMetode(string $id)
    {
        $data = MetodePembayaran::find($id);
        $title = 'Hapus Metode';

        return view('metode-pembayaran.modal-hapus', compact('title', 'data'));
    }

    public function destroy(string $id)
    {
        $data = MetodePembayaran::find($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil hapus metode',
        ]);
    }
}
