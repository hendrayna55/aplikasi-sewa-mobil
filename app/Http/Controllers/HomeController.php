<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
