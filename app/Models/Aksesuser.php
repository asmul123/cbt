<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aksesuser extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahunpelajaran_id',
        'hakakses_id',
        'user_id'
    ];

    public function Tahunpelajaran()
    {
        return $this->belongsTo(Tahunpelajaran::class);
    }
    public function Hakakses()
    {
        return $this->belongsTo(Hakakses::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
