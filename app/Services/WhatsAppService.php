<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private $baseUrl;
    private $timeout;
    private $client;

    public function __construct()
    {
        $this->baseUrl = config('whatsapp.service_url', 'https://gowa.simaru.my.id');
        $this->timeout = config('whatsapp.timeout', 30);
        $this->client = $this->getHttpClient();
    }

    /**
     * Get HTTP client with authentication
     */
    private function getHttpClient()
    {
        $client = Http::timeout($this->timeout);

        // Add Basic Authentication if configured
        $username = config('whatsapp.username');
        $password = config('whatsapp.password');

        if ($username && $password) {
            $client = $client->withBasicAuth($username, $password);
        }

        return $client;
    }

    /**
     * Send admin notification when guest checks in
     */
    public function sendAdminNotification($guest)
    {
        try {
            // Prepare the message
            $message = $this->formatCheckInMessage($guest);

            // Send to admin/security phone number
            $adminPhone = config('whatsapp.admin_phone', '628123456789');
            $adminPhone = $this->formatPhoneNumber($adminPhone);

            $result = $this->sendMessage($adminPhone, $message);

            Log::info('WhatsApp admin notification attempt', [
                'guest_name' => $guest->nama,
                'admin_phone' => $adminPhone,
                'success' => $result
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp admin notification', [
                'guest_name' => $guest->nama,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Send confirmation to guest
     */
    public function sendGuestConfirmation($guest)
    {
        try {
            // Only send if guest provided phone number
            if (empty($guest->telepon)) {
                return false;
            }

            // Clean and format phone number
            $guestPhone = $this->formatPhoneNumber($guest->telepon);

            // Prepare confirmation message
            $message = $this->formatConfirmationMessage($guest);

            $result = $this->sendMessage($guestPhone, $message);

            Log::info('WhatsApp guest confirmation attempt', [
                'guest_name' => $guest->nama,
                'guest_phone' => $guestPhone,
                'success' => $result
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp guest confirmation', [
                'guest_name' => $guest->nama,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Alias for sendAdminNotification
     */
    public function sendGuestCheckInNotification($guest)
    {
        return $this->sendAdminNotification($guest);
    }

    /**
     * Send message via WhatsApp API
     */
    private function sendMessage($phone, $message)
    {
        try {
            // Format phone sesuai dokumentasi: menggunakan @s.whatsapp.net
            $phoneFormatted = $phone . '@s.whatsapp.net';

            $payload = [
                'phone' => $phoneFormatted,
                'message' => $message,
                'is_forwarded' => false
            ];

            Log::info('Sending WhatsApp message', [
                'phone' => $phone,
                'formatted_phone' => $phoneFormatted,
                'message_preview' => substr($message, 0, 100) . '...'
            ]);

            $response = $this->client->post($this->baseUrl . '/send/message', $payload);

            if ($response->successful()) {
                Log::info("WhatsApp message sent successfully", [
                    'phone' => $phone,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::warning("WhatsApp API returned error", [
                    'phone' => $phone,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp message sending failed", [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Format check-in notification message for admin/security
     */
    private function formatCheckInMessage($guest)
    {
        $checkInTime = $guest->check_in_at->format('d F Y, H:i');

        return "🔔 *NOTIFIKASI TAMU BARU*\n\n" .
               "📋 *PTSP Kemenag Nganjuk*\n" .
               "═══════════════════════\n\n" .
               "👤 *Nama:* {$guest->nama}\n" .
               "📞 *Telepon:* " . ($guest->telepon ?: '-') . "\n" .
               "🏢 *Instansi:* " . ($guest->instansi ?: '-') . "\n" .
               "🎯 *Bidang Tujuan:* {$guest->bidangInfo->nama}\n" .
               "📝 *Keperluan:* {$guest->keperluan}\n" .
               "⏰ *Check-in:* {$checkInTime} WIB\n\n" .
               "═══════════════════════\n" .
               "_Pesan otomatis dari sistem buku tamu_";
    }

    /**
     * Format confirmation message for guest
     */
    private function formatConfirmationMessage($guest)
    {
        $checkInTime = $guest->check_in_at->format('d F Y, H:i');

        return "✅ *KONFIRMASI CHECK-IN*\n\n" .
               "Halo *{$guest->nama}*,\n\n" .
               "Terima kasih telah melakukan check-in di:\n" .
               "📋 *PTSP Kemenag Nganjuk*\n\n" .
               "📝 *Detail Kunjungan:*\n" .
               "🎯 *Bidang:* {$guest->bidangInfo->nama}\n" .
               "📍 *Keperluan:* {$guest->keperluan}\n" .
               "⏰ *Waktu:* {$checkInTime} WIB\n\n" .
               "Silakan menunggu untuk dilayani sesuai antrian.\n\n" .
               "═══════════════════════\n" .
               "_Pesan otomatis dari sistem buku tamu_";
    }

    /**
     * Format phone number to Indonesian format
     */
    private function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Convert to Indonesian format
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Check WhatsApp service status
     */
    public function checkStatus()
    {
        try {
            // Check if service is accessible
            $response = $this->client->get($this->baseUrl);

            if ($response->successful()) {
                $content = $response->body();

                // Debug log
                Log::debug('WhatsApp service response', [
                    'status' => $response->status(),
                    'content_length' => strlen($content),
                    'has_whatsapp' => strpos($content, 'WhatsApp') !== false
                ]);

                // Check if it's the WhatsApp dashboard (compatible dengan PHP 7.4)
                if (strpos($content, 'WhatsApp') !== false ||
                    strpos($content, 'QR Code') !== false ||
                    strpos($content, 'dashboard') !== false) {
                    return [
                        'status' => 'connected',
                        'message' => 'WhatsApp service is accessible and responding',
                        'dashboard_url' => $this->baseUrl,
                        'auth_status' => 'authenticated'
                    ];
                }

                return [
                    'status' => 'error',
                    'message' => 'Service responding but content not recognized',
                    'code' => $response->status()
                ];
            }

            return [
                'status' => 'error',
                'message' => 'Service not responding properly',
                'code' => $response->status()
            ];
        } catch (\Exception $e) {
            Log::error('WhatsApp status check failed: ' . $e->getMessage());

            return [
                'status' => 'error',
                'message' => 'Cannot connect to WhatsApp service: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check device connection status
     */
    public function checkDeviceStatus()
    {
        try {
            // Check devices using proper API endpoint
            $response = $this->client->get($this->baseUrl . '/app/devices');

            if ($response->successful()) {
                $devices = $response->json();

                if (!empty($devices) && is_array($devices)) {
                    return [
                        'status' => 'connected',
                        'message' => 'Device is connected and ready',
                        'devices' => $devices,
                        'device_count' => count($devices)
                    ];
                } else {
                    return [
                        'status' => 'not_connected',
                        'message' => 'No devices connected - QR code needs to be scanned',
                        'devices' => []
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to check device status',
                    'code' => $response->status()
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Login to WhatsApp service
     */
    public function login()
    {
        try {
            $response = $this->client->get($this->baseUrl . '/app/login');

            if ($response->successful()) {
                return [
                    'status' => 'success',
                    'message' => 'Login successful',
                    'data' => $response->json()
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Login failed',
                    'code' => $response->status()
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Logout from WhatsApp service
     */
    public function logout()
    {
        try {
            $response = $this->client->get($this->baseUrl . '/app/logout');

            if ($response->successful()) {
                return [
                    'status' => 'success',
                    'message' => 'Logout successful',
                    'data' => $response->json()
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Logout failed',
                    'code' => $response->status()
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Send admin notification with checkout link when guest checks in
     */
    public function sendAdminNotificationWithCheckout($guest)
    {
        try {
            // Prepare the message with checkout link
            $message = $this->formatCheckInMessageWithCheckout($guest);

            // Send to admin/security phone number
            $adminPhone = config('whatsapp.admin_phone', '628123456789');
            $adminPhone = $this->formatPhoneNumber($adminPhone);

            $result = $this->sendMessage($adminPhone, $message);

            Log::info('WhatsApp admin notification with checkout sent', [
                'guest_name' => $guest->nama,
                'guest_id' => $guest->id,
                'admin_phone' => $adminPhone,
                'success' => $result
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp admin notification with checkout', [
                'guest_name' => $guest->nama,
                'guest_id' => $guest->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Send guest confirmation with checkout link
     */
    public function sendGuestConfirmationWithCheckout($guest)
    {
        try {
            // Only send if guest provided phone number
            if (empty($guest->telepon)) {
                return false;
            }

            // Clean and format phone number
            $guestPhone = $this->formatPhoneNumber($guest->telepon);

            // Prepare confirmation message with checkout link
            $message = $this->formatConfirmationMessageWithCheckout($guest);

            $result = $this->sendMessage($guestPhone, $message);

            Log::info('WhatsApp guest confirmation with checkout sent', [
                'guest_name' => $guest->nama,
                'guest_id' => $guest->id,
                'guest_phone' => $guestPhone,
                'success' => $result
            ]);

            return $result;
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp guest confirmation with checkout', [
                'guest_name' => $guest->nama,
                'guest_id' => $guest->id,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Format check-in notification message with checkout link for admin/security
     */
    private function formatCheckInMessageWithCheckout($guest)
    {
        $checkInTime = $guest->check_in_at->format('d F Y, H:i');
        $checkoutUrl = url("/admin/guestbook/{$guest->id}/checkout");

        return "🔔 *NOTIFIKASI TAMU BARU*\n\n" .
               "📋 *PTSP Kemenag Nganjuk*\n" .
               "═══════════════════════\n\n" .
               "👤 *Nama:* {$guest->nama}\n" .
               "📞 *Telepon:* " . ($guest->telepon ?: '-') . "\n" .
               "🏢 *Instansi:* " . ($guest->instansi ?: '-') . "\n" .
               "🎯 *Bidang Tujuan:* {$guest->bidangInfo->nama}\n" .
               "📝 *Keperluan:* {$guest->keperluan}\n" .
               "⏰ *Check-in:* {$checkInTime} WIB\n\n" .
               "🔗 *Checkout Link:*\n" .
               "{$checkoutUrl}\n\n" .
               "═══════════════════════\n" .
               "_Pesan otomatis dari sistem buku tamu_";
    }

    /**
     * Format confirmation message with checkout link for guest
     */
    private function formatConfirmationMessageWithCheckout($guest)
    {
        $checkInTime = $guest->check_in_at->format('d F Y, H:i');
        $checkoutUrl = url("/checkout/{$guest->id}");

        return "✅ *KONFIRMASI CHECK-IN*\n\n" .
               "Halo *{$guest->nama}*,\n\n" .
               "Terima kasih telah melakukan check-in di:\n" .
               "📋 *PTSP Kemenag Nganjuk*\n\n" .
               "📝 *Detail Kunjungan:*\n" .
               "📍 *Instansi Asal:* {$guest->instansi}\n" .
               "🎯 *Bidang:* {$guest->bidangInfo->nama}\n" .
               "📍 *Keperluan:* {$guest->keperluan}\n" .
               "⏰ *Waktu:* {$checkInTime} WIB\n\n" .
               "🚪 *Klik link di bawah ini jika sudah selesai:*\n" .
               "{$checkoutUrl}\n\n" .
               "═══════════════════════\n" .
               "_Pesan otomatis dari sistem buku tamu_";
    }

    /**
     * Test method untuk melihat format pesan (public untuk testing)
     */
    public function testMessageFormat($guest)
    {
        return [
            'admin' => $this->formatCheckInMessageWithCheckout($guest),
            'guest' => $this->formatConfirmationMessageWithCheckout($guest)
        ];
    }
}
