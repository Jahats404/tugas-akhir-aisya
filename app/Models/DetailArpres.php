<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailArpres extends Model
{
    use HasFactory;

    protected $table = 'detail_arpres';
    protected $guarded = [];

    public function arpres()
    {
        return $this->belongsTo(Arpres::class, 'arpres_id', 'id_arpres');
    }
}
