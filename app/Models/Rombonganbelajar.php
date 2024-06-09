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
        'kurikulum_id',
        'user_id'
    ];
    public function Tahunpelajaran()
    {
        return $this->belongsTo(Tahunpelajaran::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }
}
