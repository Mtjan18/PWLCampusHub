<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class, 'user_id');
    }
    public function certificates()
    {
        return $this->hasManyThrough(
            \App\Models\Certificate::class,
            \App\Models\EventRegistration::class,
            'user_id',           // Foreign key di event_registrations
            'registration_id',   // Foreign key di certificates
            'id',                // Local key di users
            'id'                 // Local key di event_registrations
        );
    }
    public function attendances()
    {
        return $this->hasManyThrough(\App\Models\Attendance::class, \App\Models\EventRegistration::class, 'user_id', 'registration_id', 'id', 'id');
    }
}
