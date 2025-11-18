<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SurveyResponse;

class SurveyResponseSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            SurveyResponse::create([
                'guest_id' => null,
                'gender' => ['Laki-laki', 'Perempuan'][rand(0,1)],
                'age_group' => ['<20', '21-30', '31-40', '41-50', '>'][rand(0,4)],
                'purposes' => json_encode(['Pelayanan PTSP', 'Konsultasi', 'Pengajuan dokumen', 'Koordinasi/rapat', 'Lainnya'][rand(0,4)]),
                'purpose_other' => rand(0,4) == 4 ? 'Keperluan lain ' . $i : null,
                'rating_registration' => rand(44,50)/10,
                'rating_speed' => rand(44,50)/10,
                'rating_friendliness' => rand(44,50)/10,
                'rating_clarity' => rand(44,50)/10,
                'rating_comfort' => rand(44,50)/10,
                'rating_cleanliness' => rand(44,50)/10,
                'rating_system' => rand(44,50)/10,
                'rating_overall' => rand(44,50)/10,
                'comments' => 'Komentar survey ke-' . ($i+1),
                'device' => 'Seeder',
                'ip' => '127.0.0.1',
            ]);
        }
    }
}
