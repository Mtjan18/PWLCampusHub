<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'location',
        'poster_url',
        'registration_fee',
        'max_participants',
        'created_by',
        'status',
        'start_time',
        'end_time',
    ];

    /**
     * Relasi: Event dibuat oleh User (Panitia)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi: Event punya banyak sesi
     */
    public function sessions()
    {
        return $this->hasMany(EventSession::class);
    }

    /**
     * Relasi: Event punya banyak registrasi
     */
    public function registrations()
    {
        return $this->hasManyThrough(
            \App\Models\EventRegistration::class,
            \App\Models\EventSession::class,
            'event_id',    // Foreign key di event_sessions
            'session_id',  // Foreign key di event_registrations
            'id',          // Local key di events
            'id'           // Local key di event_sessions
        );
    }

    /**
     * Scope: Hanya event aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function attendances()
    {
        return $this->hasManyThrough(
            \App\Models\Attendance::class,
            \App\Models\EventSession::class,
            'event_id',    // Foreign key di event_sessions
            'session_id',  // Foreign key di attendance
            'id',          // Local key di events
            'id'           // Local key di event_sessions
        );
    }
}
