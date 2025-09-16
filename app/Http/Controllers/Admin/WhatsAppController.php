<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppService;
use App\Models\Guestbook;
use App\Models\Bidang;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    /**
     * Show WhatsApp management page
     */
    public function index()
    {
        $whatsAppService = new WhatsAppService();

        // Get service status
        $serviceStatus = $whatsAppService->checkStatus();

        // Get device status
        $deviceStatus = $whatsAppService->checkDeviceStatus();

        // Get login status (for QR code)
        $loginStatus = $whatsAppService->login();

        return view('admin.whatsapp.index', [
            'serviceStatus' => $serviceStatus,
            'deviceStatus' => $deviceStatus,
            'loginStatus' => $loginStatus,
            'config' => [
                'service_url' => config('whatsapp.service_url'),
                'admin_phone' => config('whatsapp.admin_phone'),
                'enabled' => config('whatsapp.enabled', true),
            ]
        ]);
    }

    /**
     * Test WhatsApp connection via AJAX
     */
    public function testConnection()
    {
        try {
            $whatsAppService = new WhatsAppService();

            // Test service status
            $serviceStatus = $whatsAppService->checkStatus();

            // Test device status
            $deviceStatus = $whatsAppService->checkDeviceStatus();

            return response()->json([
                'success' => true,
                'service' => $serviceStatus,
                'device' => $deviceStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test message sending via AJAX
     */
    public function testMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string',
            'type' => 'required|in:admin,guest'
        ]);

        try {
            $whatsAppService = new WhatsAppService();

            // Create test guest object
            $testGuest = new Guestbook([
                'nama' => 'Test User - ' . now()->format('H:i:s'),
                'telepon' => $request->phone,
                'instansi' => 'Test Instansi',
                'keperluan' => $request->message,
                'bidang' => 1,
                'check_in_at' => now(),
            ]);

            // Load bidang info
            $bidang = Bidang::first();
            if ($bidang) {
                $testGuest->bidangInfo = $bidang;
            }

            // Send notification based on type
            if ($request->type === 'admin') {
                $result = $whatsAppService->sendAdminNotification($testGuest);
                $message = 'Admin notification test';
            } else {
                $result = $whatsAppService->sendGuestConfirmation($testGuest);
                $message = 'Guest confirmation test';
            }

            return response()->json([
                'success' => $result,
                'message' => $result ?
                    $message . ' sent successfully' :
                    $message . ' failed to send'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
