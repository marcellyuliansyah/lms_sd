<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanTugas extends Model
{
    protected $table = 'jawaban_tugas';
    protected $guarded = [];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
