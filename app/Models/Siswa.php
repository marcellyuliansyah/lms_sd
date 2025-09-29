<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nisn', 'tanggal_lahir', 'kelas_id', 'user_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::deleting(function ($siswa) {
            // Hapus akun user terkait jika ada
            if ($siswa->user) {
                $siswa->user->delete();
            }
        });
    }
}
