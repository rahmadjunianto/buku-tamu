<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guestbook;
use App\Models\Bidang;
use App\Models\User;
use Carbon\Carbon;

class GuestbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Pastikan ada user dan bidang
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@bukutamu.com',
                'password' => bcrypt('password')
            ]);
        }

        $bidangs = Bidang::all();
        if ($bidangs->isEmpty()) {
            return;
        }

        $guestData = [
            [
                'nama' => 'Budi Santoso',
                'telepon' => '081234567890',
                'instansi' => 'PT. Teknologi Maju',
                'keperluan' => 'Meeting dengan tim IT',
                'check_in_at' => Carbon::now()->subHours(2),
                'check_out_at' => Carbon::now()->subHour(1),
                'duration_minutes' => 60,
            ],
            [
                'nama' => 'Sari Dewi',
                'telepon' => '081234567891',
                'instansi' => 'CV. Kreatif Solusi',
                'keperluan' => 'Konsultasi bisnis',
                'check_in_at' => Carbon::now()->subHours(3),
                'check_out_at' => null,
                'duration_minutes' => null,
            ],
            [
                'nama' => 'Ahmad Rahman',
                'telepon' => '081234567892',
                'instansi' => 'Universitas ABC',
                'keperluan' => 'Penelitian kolaborasi',
                'check_in_at' => Carbon::today()->subDays(1)->addHours(9),
                'check_out_at' => Carbon::today()->subDays(1)->addHours(11),
                'duration_minutes' => 120,
            ],
            [
                'nama' => 'Linda Sari',
                'telepon' => '081234567893',
                'instansi' => 'Bank XYZ',
                'keperluan' => 'Presentasi proposal',
                'check_in_at' => Carbon::today()->subDays(2)->addHours(14),
                'check_out_at' => Carbon::today()->subDays(2)->addHours(16),
                'duration_minutes' => 120,
            ],
            [
                'nama' => 'Rudi Hermawan',
                'telepon' => '081234567894',
                'instansi' => 'Freelancer',
                'keperluan' => 'Interview pekerjaan',
                'check_in_at' => Carbon::now()->subMinutes(30),
                'check_out_at' => null,
                'duration_minutes' => null,
            ],
        ];

        foreach ($guestData as $data) {
            Guestbook::create([
                'nama' => $data['nama'],
                'telepon' => $data['telepon'],
                'instansi' => $data['instansi'],
                'keperluan' => $data['keperluan'],
                'bidang' => $bidangs->random()->id,
                'check_in_at' => $data['check_in_at'],
                'check_out_at' => $data['check_out_at'],
                'duration_minutes' => $data['duration_minutes'],
            ]);
        }
    }
}
