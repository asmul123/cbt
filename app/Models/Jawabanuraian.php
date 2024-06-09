<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawabanuraian extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pengerjaan_id',
        'soal_id',
        'jawaban',
        'bobot'
    ];
}
