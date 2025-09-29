<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ ini yang benar
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'wali_kelas_id'];

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

        public function mapels()
    {
        return $this->belongsToMany(Mapel::class, 'kelas_mapel')
                    ->withPivot('guru_id')
                    ->withTimestamps();
    }
}
