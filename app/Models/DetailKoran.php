<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKoran extends Model
{
    use HasFactory;

    protected $table = 'detailkoran';
    protected $guarded = [];

    public function koran()
    {
        return $this->belongsTo(Koran::class, 'koran_id', 'id');
    }
}
