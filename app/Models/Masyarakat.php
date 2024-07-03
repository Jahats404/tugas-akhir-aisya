<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $primaryKey = 'nik';
    protected $table = 'masyarakat';
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

    public static $rules = [
        'nik' => 'required|unique:masyarakat,nik|digits:16|regex:/^3301/',
        'name' => 'required|string|max:255',
        'tanggal_lahir' => 'required',
        'kk' => 'required',
        'kecamatan' => 'required',
        'desa' => 'required',
        'email' => 'required|email|unique:users,email',
        'no_hp' => 'required',
        'password' => 'required|string|min:6',
        'password_confirmation' => 'required|same:password',
        'setuju' => 'required',
    ];

    public static $messages = [
        'name.required' => 'Nama harus diisi ya.',
        'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
        'nik.required' => 'NIK harus diisi.',
        'nik.unique' => 'NIK Sudah Terdaftar.',
        'nik.digits' => 'NIK harus terdiri dari :digits digit.',
        'nik.regex' => 'NIK harus berdomisili Cilacap.',
        'tanggal_lahir.required' => 'Tanggal Lahir harus diisi.',
        'kk.required' => 'KK harus diisi.',
        'kecamatan.required' => 'Kecamatan Harus diisi.',
        'desa.required' => 'Desa harus diisi.',
        'email.required' => 'Email harus diisi.',
        'email.email' => 'Email tidak valid.',
        'email.unique' => 'Email sudah terdaftar.',
        'no_hp.required' => 'Nomor Telepon harus diisi',
        'password.required' => 'Password harus diisi.',
        'password.min' => 'Password minimal :min karakter.',
        'password_confirmation.same' => 'Konvirmasi password salah.',
        'password_confirmation.required' => 'Konvirmasi password harus diisi.',
        'setuju' => 'Untuk melanjutkan registrasi, anda harus menyutujui segala ketentuan.',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'nik', 'id');
    }
}
