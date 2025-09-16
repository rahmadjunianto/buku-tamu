<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bidangList = [
            'Pendma',
            'Kepegawaian',
            'Umum'
        ];

        foreach ($bidangList as $nama) {
            Bidang::create(['nama' => $nama]);
        }
    }
}
