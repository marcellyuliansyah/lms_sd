<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanUjian extends Model
{
    protected $fillable = ['ujian_id', 'siswa_id', 'soal_id', 'jawaban', 'benar'];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
