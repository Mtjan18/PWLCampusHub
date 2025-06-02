<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles'; // opsional, karena default-nya sudah 'roles'

    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    // Relasi ke users (satu role punya banyak user)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
