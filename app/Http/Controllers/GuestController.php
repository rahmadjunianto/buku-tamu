<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GuestController extends Controller
{
    public function index()
    {
        $bidangs = Bidang::all();
        return view('guest.form', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'instansi' => 'nullable|string|max:255',
            'keperluan' => 'required|string|max:255',
            'bidang' => 'required|exists:bidang,id',
        ]);

        $guest = Guestbook::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'instansi' => $request->instansi,
            'keperluan' => $request->keperluan,
            'bidang' => $request->bidang,
            'check_in_at' => now(),
        ]);

        return redirect()->route('guest.success', $guest->id)->with('success', 'Terima kasih! Data Anda telah tercatat.');
    }

    public function success($id)
    {
        try {
            $guest = Guestbook::with('bidangInfo')->findOrFail($id);
            Log::info('Guest found:', $guest->toArray());
            return view('guest.success-inline', compact('guest'));
        } catch (\Exception $e) {
            Log::error('Error in success page: ' . $e->getMessage());
            return response('Error: ' . $e->getMessage(), 500);
        }
    }
}
