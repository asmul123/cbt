<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengerjaan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'penjadwalan_id',
        'rekaman',
        'status',
        'resize_count',
        'minimize_count',
        'user_id',
        'nilai'
    ];
    
    public function Penjadwalan()
    {
        return $this->belongsTo(Penjadwalan::class);
    }
}
