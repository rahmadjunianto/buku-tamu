<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guestbook;
use App\Models\Bidang;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

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

        $faker = Faker::create('id_ID');

        // Daftar instansi di bawah Kemenag Nganjuk
        $instansis = [
            'SD Negeri Nganjuk',
            'SMP Negeri 1 Nganjuk',
            'SMA Negeri 1 Nganjuk',
            'MA Al-Wasliyah Nganjuk',
            'Pesantren Al-Qur\'an Nurul Falah',
            'Madrasah Ibtidaiyah Islamiyah',
            'Madrasah Tsanawiyah As-Salaam',
            'Madrasah Aliyah Darul Hana',
            'TPQ An-Nuur',
            'Balai Latihan Kerja Nganjuk',
            'UPTD Pendidikan Kecamatan Nganjuk',
            'Kantor Urusan Agama Kecamatan Nganjuk',
            'PPL Nganjuk',
            'KUA Kecamatan Nganjuk',
            'Sekolah Dasar Islam Terpadu',
            'Pondok Pesantren Assalaam',
            'Yayasan Pendidikan Islam Nganjuk',
            'Panti Asuhan Al-Ikhlas',
            'Pusat Kegiatan Belajar Masyarakat',
            'Dinas Pendidikan Kabupaten Nganjuk',
        ];

        // Tujuan kunjungan yang umum
        $keperluan = [
            'Konsultasi pendidikan',
            'Verifikasi dokumen',
            'Laporan kegiatan',
            'Koordinasi program',
            'Perizinan kegiatan',
            'Monitoring dan evaluasi',
            'Sosialisasi program pemerintah',
            'Pelatihan guru',
            'Workshop kurikulum',
            'Diskusi kebijakan pendidikan',
            'Pembahasan KKM',
            'Koordinasi ujian nasional',
            'Pelaporan hasil akademik',
            'Kunjungan industri',
            'Studi banding',
        ];

        // Generate 50 records untuk Oktober 2025
        for ($i = 0; $i < 50; $i++) {
            $checkInDate = Carbon::create(2025, 10, rand(1, 31), rand(7, 17), rand(0, 59));
            
            Guestbook::create([
                'nama' => $faker->name(),
                'telepon' => $faker->phoneNumber(),
                'instansi' => $faker->randomElement($instansis),
                'keperluan' => $faker->randomElement($keperluan),
                'bidang' => $bidangs->random()->id,
                'check_in_at' => $checkInDate,
            ]);
        }

        // Generate 50 records untuk November 2025
        for ($i = 0; $i < 50; $i++) {
            $checkInDate = Carbon::create(2025, 11, rand(1, 30), rand(7, 17), rand(0, 59));
            
            Guestbook::create([
                'nama' => $faker->name(),
                'telepon' => $faker->phoneNumber(),
                'instansi' => $faker->randomElement($instansis),
                'keperluan' => $faker->randomElement($keperluan),
                'bidang' => $bidangs->random()->id,
                'check_in_at' => $checkInDate,
            ]);
        }
    }
}

