<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Guestbook;

class SurveyResponse extends Model
{
    protected $table = 'survey_responses';

    protected $fillable = [
        'guest_id',
        'gender',
        'age_group',
        'purposes',
        'purpose_other',
        'rating_registration',
        'rating_speed',
        'rating_friendliness',
        'rating_clarity',
        'rating_comfort',
        'rating_cleanliness',
        'rating_system',
        'rating_overall',
        'comments',
        'device',
        'ip',
    ];

    protected $casts = [
        'purposes' => 'array',
    ];

    public function guest()
    {
        return $this->belongsTo(Guestbook::class, 'guest_id');
    }
}
