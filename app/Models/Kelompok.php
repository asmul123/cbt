<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tahunpelajaran_id',
        'rombonganbelajar_id',
        'ruangan_id'
    ];
    
    public function Tahunpelajaran()
    {
        return $this->belongsTo(Tahunpelajaran::class);
    }

    public function Rombonganbelajar()
    {
        return $this->belongsTo(Rombonganbelajar::class);
    }

    public function Ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
    
}
