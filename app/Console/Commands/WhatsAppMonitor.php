<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class WhatsAppMonitor extends Command
{
    protected $signature = 'whatsapp:monitor';
    protected $description = 'Monitor WhatsApp service status and device connection';

    public function handle()
    {
        $this->info('📱 WhatsApp Service Monitor');
        $this->line('════════════════════════');
        $this->newLine();

        $service = new WhatsAppService();

        // 1. Service Status
        $this->info('🔍 1. Service Status:');
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

        // 2. Device Status
        $this->info('📱 2. Device Status:');
        $deviceStatus = $service->checkDeviceStatus();

        if ($deviceStatus['status'] === 'connected') {
            $this->info('   ✅ Device: CONNECTED');
            $this->info('   ✅ Active devices: ' . $deviceStatus['device_count']);
        } elseif ($deviceStatus['status'] === 'not_connected') {
            $this->warn('   ⚠️  Device: NOT CONNECTED');
            $this->warn('   ⚠️  ' . $deviceStatus['message']);
        } else {
            $this->error('   ❌ Device: ERROR');
            $this->error('   ❌ ' . $deviceStatus['message']);
        }

        $this->newLine();

        // 3. Login Status & QR Code
        $this->info('🔐 3. Login Status:');
        $loginStatus = $service->login();

        if ($loginStatus['status'] === 'success' && isset($loginStatus['data']['results'])) {
            $results = $loginStatus['data']['results'];

            if (isset($results['qr_link'])) {
                $this->warn('   🔍 QR Code tersedia:');
                $this->warn('   📷 QR Link: ' . $results['qr_link']);
                $this->warn('   ⏰ Duration: ' . ($results['qr_duration'] ?? 'Unknown') . ' seconds');
                $this->warn('   📱 Scan dengan WhatsApp untuk connect device');
            } else {
                $this->info('   ✅ Login status: Active');
            }
        } else {
            $this->error('   ❌ Login failed: ' . ($loginStatus['message'] ?? 'Unknown error'));
        }

        $this->newLine();

        // 4. Configuration
        $this->info('⚙️  4. Configuration:');
        $this->info('   📡 Service URL: ' . config('whatsapp.service_url'));
        $this->info('   📞 Admin Phone: ' . config('whatsapp.admin_phone'));
        $this->info('   👤 Username: ' . config('whatsapp.username'));

        $this->newLine();

        // 5. Next Steps
        $this->info('📋 Next Steps:');
        if ($deviceStatus['status'] === 'not_connected') {
            $this->warn('   1. Buka dashboard: ' . $status['dashboard_url']);
            $this->warn('   2. Login dengan: admin / admin');
            $this->warn('   3. Scan QR Code dengan WhatsApp');
            $this->warn('   4. Tunggu device connected');
            $this->warn('   5. Test: php artisan whatsapp:test --type=admin');
        } elseif ($deviceStatus['status'] === 'connected') {
            $this->info('   ✅ Ready to send notifications!');
            $this->info('   🧪 Test: php artisan whatsapp:test --type=admin');
        }

        return 0;
    }
}
