<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjadwalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kelompok_id',
        'judultugas',
        'deskripsitugas',
        'banksoal_id',
        'acaksoal',
        'acakjawaban',
        'durasi',
        'waktumulai',
        'waktuselesai',
        'terlambat',
        'token',
        'user_id'
    ];
    
    public function Banksoal()
    {
        return $this->belongsTo(Banksoal::class);
    }
    
    public function Kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }
    
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
