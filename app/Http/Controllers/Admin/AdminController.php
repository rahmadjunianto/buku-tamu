<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guestbook;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        // Statistik untuk dashboard
        $tamuHariIni = Guestbook::whereDate('check_in_at', today())->count();
        $totalTamu = Guestbook::count();
        $tamuBelumCheckout = Guestbook::whereNull('check_out_at')->count();
        $totalBidang = Bidang::count();

        // Tamu terbaru
        $tamuTerbaru = Guestbook::with(['bidangInfo'])
            ->orderBy('check_in_at', 'desc')
            ->limit(5)
            ->get();

        // Statistik per bidang
        $statistikBidang = Bidang::withCount('guestbook')->get();

        return view('admin.dashboard', compact(
            'tamuHariIni',
            'totalTamu',
            'tamuBelumCheckout',
            'totalBidang',
            'tamuTerbaru',
            'statistikBidang'
        ));
    }
}
