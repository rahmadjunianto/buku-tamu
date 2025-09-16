<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use App\Models\Bidang;
use App\Services\WhatsAppService;
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

        // Load bidang relationship
        $guest->load('bidangInfo');

        // Send WhatsApp notifications if enabled
        if (config('whatsapp.enabled', true)) {
            try {
                $whatsAppService = new WhatsAppService();

                // // Send admin notification
                // $whatsAppService->sendAdminNotificationWithCheckout($guest);

                // Send guest confirmation if phone number provided
                if (!empty($guest->telepon)) {
                    $whatsAppService->sendGuestConfirmationWithCheckout($guest);
                }

                Log::info('WhatsApp notifications sent for guest check-in', [
                    'guest_id' => $guest->id,
                    'guest_name' => $guest->nama
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send WhatsApp notifications', [
                    'guest_id' => $guest->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

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

    public function checkout($id)
    {
        try {
            $guest = Guestbook::findOrFail($id);

            // Check if already checked out
            if ($guest->check_out_at) {
                return view('guest.checkout', [
                    'guest' => $guest,
                    'message' => 'Anda sudah melakukan checkout sebelumnya.',
                    'type' => 'info'
                ]);
            }

            // Update checkout time
            $guest->check_out_at = now();
            $guest->duration_minutes = $guest->check_in_at->diffInMinutes($guest->check_out_at);
            $guest->save();

            Log::info('Guest checkout completed', [
                'guest_id' => $guest->id,
                'guest_name' => $guest->nama,
                'duration' => $guest->duration_minutes
            ]);

            return view('guest.checkout', [
                'guest' => $guest,
                'message' => 'Terima kasih! Checkout berhasil dilakukan.',
                'type' => 'success'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in checkout: ' . $e->getMessage());
            return view('guest.checkout', [
                'guest' => null,
                'message' => 'Terjadi kesalahan saat checkout.',
                'type' => 'error'
            ]);
        }
    }
}
