<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'banksoal_id',
        'jenissoal_id',
        'soal',
        'jawaban',
        'kunci'
    ];

    public function Jenissoal()
    {
        return $this->belongsTo(Jenissoal::class);
    }
}
