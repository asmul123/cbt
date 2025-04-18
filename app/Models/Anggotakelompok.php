<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggotakelompok extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tahunpelajaran_id',
        'kelompok_id',
        'user_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }
}
