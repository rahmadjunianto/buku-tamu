<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class WhatsAppStatus extends Command
{
    protected $signature = 'whatsapp:status';
    protected $description = 'Check detailed WhatsApp service and device status';

    public function handle()
    {
        $this->info('🔍 WhatsApp Service Diagnostic...');
        $this->newLine();

        $service = new WhatsAppService();

        // 1. Service Status
        $this->info('1️⃣ Service Accessibility:');
        $status = $service->checkStatus();

        if ($status['status'] === 'connected') {
            $this->info('   ✅ Service: ONLINE');
            $this->info('   ✅ Dashboard: ' . $status['dashboard_url']);
            $this->info('   ✅ Auth: ' . $status['auth_status']);
        } else {
            $this->error('   ❌ Service: OFFLINE');
            $this->error('   ❌ Error: ' . $status['message']);
            return 1;
        }

        $this->newLine();

        // 2. Configuration
        $this->info('2️⃣ Configuration:');
        $this->info('   📡 Service URL: ' . config('whatsapp.service_url'));
        $this->info('   📞 Admin Phone: ' . config('whatsapp.admin_phone'));
        $this->info('   👤 Username: ' . config('whatsapp.username'));
        $this->info('   🔑 Password: ' . (config('whatsapp.password') ? 'SET' : 'NOT SET'));

        $this->newLine();

        // 3. Test Connection
        $this->info('3️⃣ Device Connection Test:');
        try {
            $testPhone = config('whatsapp.admin_phone');
            $testMessage = '🔍 Test connection from Laravel - ' . now()->format('H:i:s');

            // Simple test without sending actual message
            $this->info('   📱 Testing endpoint /send/message...');

            // Use HTTP client to test endpoint
            $client = \Illuminate\Support\Facades\Http::withBasicAuth(
                config('whatsapp.username'),
                config('whatsapp.password')
            )->timeout(10);

            $response = $client->post(config('whatsapp.service_url') . '/send/message', [
                'phone' => $testPhone . '@c.us',
                'message' => $testMessage,
                'is_forwarded' => false
            ]);

            if ($response->successful()) {
                $this->info('   ✅ Device: CONNECTED & READY');
                $this->info('   ✅ Message can be sent');
            } elseif ($response->status() === 500) {
                $body = $response->json();
                if (isset($body['message']) && str_contains($body['message'], 'unknown server c.us')) {
                    $this->warn('   ⚠️  Device: NOT CONNECTED');
                    $this->warn('   ⚠️  QR Code needs to be scanned');
                } else {
                    $this->error('   ❌ Device: ERROR - ' . ($body['message'] ?? 'Unknown error'));
                }
            } else {
                $this->error('   ❌ API Error: ' . $response->status() . ' - ' . $response->body());
            }

        } catch (\Exception $e) {
            $this->error('   ❌ Connection failed: ' . $e->getMessage());
        }

        $this->newLine();

        // 4. Next Steps
        $this->info('📋 Next Steps:');
        if ($status['status'] === 'connected') {
            $this->info('   1. Open dashboard: ' . $status['dashboard_url']);
            $this->info('   2. Login with: admin / admin');
            $this->info('   3. Scan QR Code with WhatsApp');
            $this->info('   4. Wait for "Device Connected Successfully"');
            $this->info('   5. Test with: php artisan whatsapp:test --type=admin');
        } else {
            $this->error('   1. Fix service connectivity first');
            $this->error('   2. Check network and credentials');
        }

        return 0;
    }
}
