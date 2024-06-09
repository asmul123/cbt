<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggotarombel extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahunpelajaran_id',
        'rombonganbelajar_id',
        'user_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
