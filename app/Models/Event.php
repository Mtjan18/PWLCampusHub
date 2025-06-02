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
        'time',
        'location',
        'poster_url',
        'registration_fee',
        'max_participants',
        'created_by',
        'status',
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
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Scope: Hanya event aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
