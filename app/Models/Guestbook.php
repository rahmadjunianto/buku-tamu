<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    use HasFactory;

    protected $table = 'guestbook';

    protected $fillable = [
        'nama',
        'telepon',
        'instansi',
        'keperluan',
        'bidang',
        'check_in_at',
        'check_out_at',
        'duration_minutes',
    ];

    protected $casts = [
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
    ];

    // Relasi ke bidang
    public function bidangInfo()
    {
        return $this->belongsTo(Bidang::class, 'bidang');
    }
}
