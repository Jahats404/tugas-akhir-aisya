<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apribadi extends Model
{
    use HasFactory;
    protected $table = 'pribadi';
    protected $guarded = [];
    protected $keyType = 'string';
    protected $primaryKey = 'id_arpri';

    // protected static function boot(){
    //     parent::boot();
    //     static::creating(function ($model){
    //         if (empty($model->{$model->getKeyName()})) {
    //             $model->{$model->getKeyName()} = Str::uuid()->toString();
    //         }
    //     });
    // }

    public static $rules = [
        'image' => 'mimes:jpeg,png,jpg,pdf|max:2048|required',
        'kategori' => 'required',
    ];

    public static $messages = [
        'image.required' => 'Anda belum mengisi Dokumen',
        'image.mimes' => 'Dokumen harus berformat jpeg,png,jpg,pdf',
        'image.max' => 'Ukuran Dokumen maksimal 2MB',
        'kategori.required' => 'Kategori harus diisi'  
    ];

    public function getIncrementing(){
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function users(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
