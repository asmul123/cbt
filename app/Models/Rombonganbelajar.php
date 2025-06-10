<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombonganbelajar extends Model
{
    use HasFactory;
    protected $fillable = [
        'tahunpelajaran_id',
        'rombongan_belajar',
        'tingkat',
    ];
    public function Tahunpelajaran()
    {
        return $this->belongsTo(Tahunpelajaran::class);
    }
}
