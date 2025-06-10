<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $table = 'event_registrations';
    public $timestamps = false; // karena pakai registered_at, bukan created_at

    protected $fillable = [
        'user_id',
        'session_id',
        'payment_proof_url',
        'payment_status',
        'qr_code',
        'registered_at'
    ];

    public function session()
    {
        return $this->belongsTo(EventSession::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'registration_id');
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class, 'registration_id');
    }
}
