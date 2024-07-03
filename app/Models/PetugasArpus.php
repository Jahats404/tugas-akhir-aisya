<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasArpus extends Model
{
    use HasFactory;
    protected $primaryKey = 'nik';
    protected $table = 'petugas_arpus';
    protected $fillable = [
        'nik',
        'name',
        'tanggal_lahir',
        'kk',
        'no_hp',
        'url',
        'kecamatan',
        'desa',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'nik', 'id');
    }
}
