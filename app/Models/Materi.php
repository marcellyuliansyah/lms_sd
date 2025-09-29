<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = ['kelas_mapel_id', 'guru_id', 'judul', 'deskripsi', 'file'];

    public function kelasMapel()
    {
        return $this->belongsTo(KelasMapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}
