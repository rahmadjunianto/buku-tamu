<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Guestbook;
use App\Models\Bidang;
use App\Services\WhatsAppService;

class WhatsAppTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test
                            {--type=admin : Type of test message (admin/guest/both)}
                            {--phone= : Phone number to send test message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test WhatsApp notification with sample guest data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🧪 Testing WhatsApp Notification...');
        $this->newLine();

        // Create test guest data
        $testGuest = new Guestbook([
            'nama' => 'Test User - ' . now()->format('H:i:s'),
            'telepon' => $this->option('phone') ?: '08123456789',
            'instansi' => 'PT Test Company',
            'keperluan' => 'Test keperluan untuk demonstrasi',
            'bidang' => 1,
            'check_in_at' => now(),
        ]);

        // Set ID untuk URL generation
        $testGuest->id = 999;

        // Load bidang info
        $bidang = Bidang::first();
        if ($bidang) {
            $testGuest->bidangInfo = $bidang;
        } else {
            $testGuest->bidangInfo = (object)['nama' => 'Test Bidang'];
        }

        $whatsAppService = new WhatsAppService();
        $type = $this->option('type');

        // Test service status first
        $this->info('1️⃣ Checking WhatsApp service status...');
        $status = $whatsAppService->checkStatus();

        if ($status['status'] !== 'connected') {
            $this->error('❌ WhatsApp service not available: ' . $status['message']);
            return 1;
        }
        $this->info('✅ WhatsApp service is online');

        // Test device status
        $this->info('2️⃣ Checking device status...');
        $deviceStatus = $whatsAppService->checkDeviceStatus();

        if ($deviceStatus['status'] !== 'connected') {
            $this->warn('⚠️  Device not connected: ' . $deviceStatus['message']);
            $this->info('📱 Please scan QR code at: ' . config('whatsapp.service_url'));
        } else {
            $this->info('✅ Device is connected');
        }

        $this->newLine();

        // Show message format
        $this->info('3️⃣ Message Format Preview:');
        $messages = $whatsAppService->testMessageFormat($testGuest);

        if (in_array($type, ['admin', 'both'])) {
            $this->line('📱 Admin Message:');
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->line($messages['admin']);
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->newLine();
        }

        if (in_array($type, ['guest', 'both'])) {
            $this->line('👤 Guest Message:');
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->line($messages['guest']);
            $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->newLine();
        }

        // Send actual messages if device is connected
        if ($deviceStatus['status'] === 'connected') {
            if ($this->confirm('Send actual WhatsApp messages?', false)) {
                $this->info('4️⃣ Sending messages...');

                if (in_array($type, ['admin', 'both'])) {
                    $this->info('📤 Sending admin notification...');
                    $result = $whatsAppService->sendAdminNotificationWithCheckout($testGuest);
                    if ($result) {
                        $this->info('✅ Admin notification sent successfully');
                    } else {
                        $this->error('❌ Failed to send admin notification');
                    }
                }

                if (in_array($type, ['guest', 'both'])) {
                    $this->info('📤 Sending guest confirmation...');
                    $result = $whatsAppService->sendGuestConfirmationWithCheckout($testGuest);
                    if ($result) {
                        $this->info('✅ Guest confirmation sent successfully');
                    } else {
                        $this->error('❌ Failed to send guest confirmation');
                    }
                }
            }
        } else {
            $this->warn('⚠️  Skipping actual message sending because device is not connected');
        }

        $this->newLine();
        $this->info('✨ Test completed!');

        return 0;
    }
}
