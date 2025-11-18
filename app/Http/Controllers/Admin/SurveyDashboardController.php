<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurveyResponse;

class SurveyDashboardController extends Controller
{
    public function index()
    {
        return view('admin.surveys-dashboard');
    }

    public function data()
    {
        $fields = [
            'rating_registration',
            'rating_speed',
            'rating_friendliness',
            'rating_clarity',
            'rating_comfort',
            'rating_cleanliness',
            'rating_system',
            'rating_overall',
        ];
        $labels = [
            'Pendaftaran',
            'Kecepatan',
            'Keramahan',
            'Kejelasan',
            'Kenyamanan',
            'Kebersihan',
            'Sistem',
            'Kepuasan Keseluruhan',
        ];
        $ratings = [];
        foreach ($fields as $field) {
            $ratings[] = round(SurveyResponse::avg($field), 2);
        }

        // Gender distribution
        $genderLabels = ['Laki-laki', 'Perempuan'];
        $genderCounts = [];
        foreach ($genderLabels as $g) {
            $genderCounts[] = SurveyResponse::where('gender', $g)->count();
        }

        // Age group distribution
        $ageLabels = ['<20', '21-30', '31-40', '41-50', '>'];
        $ageCounts = [];
        foreach ($ageLabels as $a) {
            $ageCounts[] = SurveyResponse::where('age_group', $a)->count();
        }

        return response()->json([
            'labels' => $labels,
            'ratings' => $ratings,
            'genderLabels' => $genderLabels,
            'genderCounts' => $genderCounts,
            'ageLabels' => $ageLabels,
            'ageCounts' => $ageCounts,
        ]);
    }
}
