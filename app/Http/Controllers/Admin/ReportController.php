<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guestbook;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $bidangId = $request->get('bidang_id');

        $query = Guestbook::with('bidangInfo')
            ->whereBetween('check_in_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

        if ($bidangId) {
            $query->where('bidang', $bidangId);
        }

        $guests = $query->orderBy('check_in_at', 'desc')->paginate(20);

        // Statistik
        $totalTamu = $query->count();
        $tamuSelesai = $query->whereNotNull('check_out_at')->count();
        $tamuBelumSelesai = $totalTamu - $tamuSelesai;
        $rataRataDurasi = $query->whereNotNull('duration_minutes')->avg('duration_minutes');

        // Statistik per bidang
        $statistikBidang = Guestbook::select('bidang', DB::raw('COUNT(*) as total'))
            ->with('bidangInfo')
            ->whereBetween('check_in_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ])
            ->groupBy('bidang')
            ->get();

        $bidangs = Bidang::all();

        return view('admin.reports.index', compact(
            'guests', 'startDate', 'endDate', 'bidangId', 'bidangs',
            'totalTamu', 'tamuSelesai', 'tamuBelumSelesai', 'rataRataDurasi', 'statistikBidang'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $bidangId = $request->get('bidang_id');

        $query = Guestbook::with('bidangInfo')
            ->whereBetween('check_in_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

        if ($bidangId) {
            $query->where('bidang', $bidangId);
        }

        $guests = $query->orderBy('check_in_at', 'desc')->get();

        $filename = 'laporan_kunjungan_' . $startDate . '_' . $endDate . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($guests) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'No', 'Nama', 'Telepon', 'Instansi', 'Keperluan', 'Bidang',
                'Check In', 'Check Out', 'Durasi (menit)', 'Status'
            ]);

            // Data
            foreach ($guests as $index => $guest) {
                fputcsv($file, [
                    $index + 1,
                    $guest->nama,
                    $guest->telepon ?? '-',
                    $guest->instansi ?? '-',
                    $guest->keperluan,
                    $guest->bidangInfo->nama ?? '-',
                    $guest->check_in_at->format('d/m/Y H:i:s'),
                    $guest->check_out_at ? $guest->check_out_at->format('d/m/Y H:i:s') : '-',
                    $guest->duration_minutes ?? '-',
                    $guest->check_out_at ? 'Selesai' : 'Belum Selesai'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
