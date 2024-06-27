<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arpres extends Model
{
    use HasFactory;

    protected $table = 'arsip_histori_prestasi';
    protected $primaryKey = 'id_arpres';
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function detailArpres()
    {
        return $this->hasMany(DetailArpres::class, 'arpres_id', 'id_arpres');
    }
}
