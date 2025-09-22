<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    protected $table = 'ujian';
    protected $fillable = ['mapel_id', 'guru_id', 'judul', 'waktu_mulai', 'waktu_selesai'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'jadwal_ujian_id');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanUjian::class, 'ujian_id');
    }
}
