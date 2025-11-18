<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use App\Models\Guestbook;

class SurveyController extends Controller
{
    public function create($guestId = null)
    {
        $guest = null;
        if ($guestId) {
            $guest = Guestbook::find($guestId);
        }
        return view('guest.survey', compact('guest'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'guest_id' => 'required|exists:guestbook,id',
            'gender' => 'required|string',
            'age_group' => 'required|string',
            'purposes' => 'required|array|min:1',
            // 'purpose_other' => 'sometimes|required_if:purposes,Lainnya|string|max:255',
            'rating_registration' => 'required|integer|min:1|max:5',
            'rating_speed' => 'required|integer|min:1|max:5',
            'rating_friendliness' => 'required|integer|min:1|max:5',
            'rating_clarity' => 'required|integer|min:1|max:5',
            'rating_comfort' => 'required|integer|min:1|max:5',
            'rating_cleanliness' => 'required|integer|min:1|max:5',
            'rating_system' => 'required|integer|min:1|max:5',
            'rating_overall' => 'required|integer|min:1|max:5',
            'comments' => 'required|string|max:2000',
        ], [
            'guest_id.required' => 'ID tamu wajib diisi.',
            'guest_id.exists' => 'ID tamu tidak valid.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'age_group.required' => 'Usia wajib dipilih.',
            'purposes.required' => 'Anda wajib memilih minimal satu keperluan kunjungan.',
            // 'purposes.min' => 'Anda wajib memilih minimal satu keperluan kunjungan.',
            // 'purpose_other.required_if' => 'Jika memilih "Lainnya" pada keperluan kunjungan, kolom ini wajib diisi.',
            // 'purpose_other.string' => 'Kolom keperluan lainnya harus berupa teks.',
            'purpose_other.max' => 'Kolom keperluan lainnya maksimal 255 karakter.',
            'rating_registration.required' => 'Penilaian kemudahan pendaftaran wajib diisi.',
            'rating_speed.required' => 'Penilaian kecepatan pelayanan wajib diisi.',
            'rating_friendliness.required' => 'Penilaian keramahan petugas wajib diisi.',
            'rating_clarity.required' => 'Penilaian kejelasan informasi wajib diisi.',
            'rating_comfort.required' => 'Penilaian kenyamanan ruang wajib diisi.',
            'rating_cleanliness.required' => 'Penilaian kebersihan wajib diisi.',
            'rating_system.required' => 'Penilaian kemudahan sistem wajib diisi.',
            'rating_overall.required' => 'Penilaian kepuasan keseluruhan wajib diisi.',
            'comments.required' => 'Saran & masukan wajib diisi.',
            'comments.max' => 'Saran & masukan maksimal 2000 karakter.',
        ]);

        $data['device'] = $request->header('User-Agent');
        $data['ip'] = $request->ip();

        // store purposes as json if present
        if (isset($data['purposes']) && is_array($data['purposes'])) {
            $data['purposes'] = array_values($data['purposes']);
        }

        SurveyResponse::create($data);

        return redirect()->route('survey.thanks');
    }

    public function thanks()
    {
        return view('guest.survey-thanks');
    }
}
