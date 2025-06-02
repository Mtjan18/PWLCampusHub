<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    protected $table = 'event_registrations';

    protected $fillable = [
        'user_id',
        'event_id',
        'payment_proof_url',
        'payment_status',
        'qr_code',
        'registered_at',
    ];

    public $timestamps = false; // karena kolom timestamp kamu tidak bernama created_at/updated_at

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Event
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
