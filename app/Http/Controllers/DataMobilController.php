<?php

namespace App\Http\Controllers;

use App\Models\DataMobil;
use Illuminate\Http\Request;

class DataMobilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DataMobil::orderBy('created_at', 'desc')->get();
        return view('mobil.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function modalTambahMobil()
    {
        $title = "Tambah Mobil";

        return view('mobil.modal-tambah', compact('title'));
    }

    public function store(Request $request)
    {
        DataMobil::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah mobil',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function modalEditMobil(string $id)
    {
        $title = "Edit Mobil";
        $data = DataMobil::find($id);

        return view('mobil.modal-edit', compact('title', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DataMobil::find($id)->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengedit mobil',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function modalHapusMobil(string $id)
    {
        $data = DataMobil::find($id);
        $title = "Hapus Mobil " . $data->plat_nomor;

        return view('mobil.modal-hapus', compact('title', 'data'));
    }

    public function destroy(string $id)
    {
        $data = DataMobil::find($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus mobil',
        ]);
    }
}
