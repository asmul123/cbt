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
        'server_id',
        'user_id',
    ];

    public function Tahunpelajaran()
    {
        return $this->belongsTo(Tahunpelajaran::class);
    }
    
    public function Server()
    {
        return $this->belongsTo(Server::class);
    }
}
