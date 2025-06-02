<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'name',
    ];

    /**
     * Relasi: Speaker milik satu EventSession
     */
    public function session()
    {
        return $this->belongsTo(EventSession::class, 'session_id');
    }
}
