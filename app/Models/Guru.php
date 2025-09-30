<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ ini yang benar
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

   protected $fillable = ['nama', 'nip', 'email', 'telepon','password', 'user_id'];

    public function kelasMapel()
    {
        return $this->hasMany(KelasMapel::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
