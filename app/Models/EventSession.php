<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSession extends Model
{
    use HasFactory;

    protected $table = 'event_sessions';

    protected $fillable = [
        'event_id',
        'name',
        'session_date',
        'session_time',
        'location',
    ];

    /**
     * Relasi: EventSession milik satu Event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relasi: EventSession memiliki banyak Speaker
     */
    public function speakers()
    {
        return $this->hasMany(Speaker::class, 'session_id');
    }

    /**
     * Relasi: EventSession memiliki banyak Attendance (kehadiran)
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }
}
