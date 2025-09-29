<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapels';
    protected $fillable = ['nama'];

    // Relasi ke kelas (many-to-many)
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mapel')
                    ->withPivot('guru_id')
                    ->withTimestamps();
    }
}
