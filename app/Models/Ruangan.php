<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tahunpelajaran_id',
        'ruangan',
    ];
    public function Tahunpelajaran()
    {
        return $this->belongsTo(Tahunpelajaran::class);
    }
}
