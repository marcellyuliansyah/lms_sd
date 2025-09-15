<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'judul',
        'deskripsi',
        'file',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
