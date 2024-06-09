<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banksoal extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'matapelajaran_id',
        'kodesoal',
        'user_id'
    ];
    
    public function Matapelajaran()
    {
        return $this->belongsTo(Matapelajaran::class);
    }
}
