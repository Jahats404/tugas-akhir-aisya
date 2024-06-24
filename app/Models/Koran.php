<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koran extends Model
{
    use HasFactory;

    protected $table = 'koran';
    protected $guarded = [];
    
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function detailKoran()
    {
        return $this->hasMany(DetailKoran::class, 'koran_id', 'id');
    }
}
