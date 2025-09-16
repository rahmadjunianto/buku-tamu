<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guestbook;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GuestbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guests = Guestbook::with(['bidangInfo'])
            ->orderBy('check_in_at', 'desc')
            ->paginate(15);

        return view('admin.guestbook.index', compact('guests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bidangs = Bidang::all();
        return view('admin.guestbook.create', compact('bidangs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'instansi' => 'nullable|string|max:255',
            'keperluan' => 'required|string|max:255',
            'bidang' => 'required|exists:bidang,id',
        ]);

        Guestbook::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'instansi' => $request->instansi,
            'keperluan' => $request->keperluan,
            'bidang' => $request->bidang,
            'check_in_at' => now(),
        ]);

        return redirect()->route('admin.guestbook.index')
            ->with('success', 'Tamu berhasil didaftarkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guest = Guestbook::with(['bidangInfo'])->findOrFail($id);
        return view('admin.guestbook.show', compact('guest'));
    }

    /**
     * Checkout guest
     */
    public function checkout($id)
    {
        $guest = Guestbook::findOrFail($id);

        if ($guest->check_out_at) {
            return back()->with('error', 'Tamu sudah checkout');
        }

        $checkOutTime = now();
        $duration = $checkOutTime->diffInMinutes($guest->check_in_at);

        $guest->update([
            'check_out_at' => $checkOutTime,
            'duration_minutes' => $duration,
        ]);

        return back()->with('success', 'Checkout berhasil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guest = Guestbook::findOrFail($id);
        $bidangs = Bidang::all();
        return view('admin.guestbook.edit', compact('guest', 'bidangs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $guest = Guestbook::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'instansi' => 'nullable|string|max:255',
            'keperluan' => 'required|string|max:255',
            'bidang' => 'required|exists:bidang,id',
        ]);

        $guest->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'instansi' => $request->instansi,
            'keperluan' => $request->keperluan,
            'bidang' => $request->bidang,
        ]);

        return redirect()->route('admin.guestbook.index')
            ->with('success', 'Data tamu berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guest = Guestbook::findOrFail($id);
        $guest->delete();

        return redirect()->route('admin.guestbook.index')
            ->with('success', 'Data tamu berhasil dihapus');
    }
}
