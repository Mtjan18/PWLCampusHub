<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'session_id',
        'scan_time',
        'scanned_by',
    ];

    /**
     * Relasi: Kehadiran milik satu sesi event
     */
    public function session()
    {
        return $this->belongsTo(EventSession::class, 'session_id');
    }

    /**
     * Relasi: Kehadiran milik satu registrasi event
     */
    public function registration()
    {
        return $this->belongsTo(EventRegistration::class, 'registration_id');
    }

    /**
     * Relasi: Yang melakukan scan adalah User (panitia)
     */
    public function scanner()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
