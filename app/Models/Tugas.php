<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';
    protected $guarded = [];

    public function guru()   { return $this->belongsTo(User::class, 'guru_id'); }
    public function matapelajaran()  { return $this->belongsTo(MataPelajaran::class, 'matapelajaran_id'); }
    public function kelas()  { return $this->belongsTo(Kelas::class, 'kelas_id'); }
    public function jawaban(){ return $this->hasMany(JawabanTugas::class, 'tugas_id'); }
}
