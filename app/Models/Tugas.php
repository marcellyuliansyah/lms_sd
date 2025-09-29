<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_mapel_id','guru_id','judul','deskripsi','deadline'];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
