<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('masyarakat.profile', compact('user'));
    }

    public function update_profile(Request $request){
        $request->validate([
            'name' => 'required',
            
        ]);

        // $arsip = Apendidikan::findOrFail($id_arpen);
        $profile = User::findOrFail(Auth::user()->id);
        $profile->name = $request->input('name');
        $profile->tanggal_lahir = $request->input('tanggal_lahir');
        $profile->no_hp = $request->input('no_hp');
        $profile->email = $request->input('email');
        $profile->save();
    
        return redirect()->back()->with('success', 'Profile berhasil diperbarui.');
    }
    
//============================================================================================================

    public function update_password(Request $request)
    {
        // Validasi input
        // $request->validate([
            //     'current_password' => 'required',
            //     'new_password' => 'required|min:8|confirmed',
            // ]);
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'konfirmasi_password' => 'required|min:8|same:new_password',
        ];
        $messages = [
            'current_password.required' => 'Password lama tidak boleh kosong!',
            'new_password.required' => 'Password baru tidak boleh kosong!',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'konfirmasi_password.required' => 'Konfirmasi Password tidak boleh kosong!',
            'konfirmasi_password.min' => 'Password minimal 8 karakter',
            'konfirmasi_password.same' => 'Konfirmasi Password harus sama dengan Password baru!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }
            
            // Ambil user saat ini yang sedang login
        $user = User::findOrFail(Auth::user()->id);

        // Periksa apakah password lama sesuai dengan yang ada di database
        if (Hash::check($request->current_password, $user->password)) {
            // Jika password lama sesuai, ubah password baru
            if ($request->new_password == $request->konfirmasi_password) {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
            } else {
                return redirect()->back()->with('error', 'Konfirmasi Password salah.');
            }

            return redirect()->back()->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->back()->with('error', 'Password lama tidak sesuai.');
        }
    }

    public function update_fotodir(Request $request){
        
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $user = User::findOrFail(Auth::user()->id);

            // Hapus foto profil lama jika ada
            if ($user->url) {
                Storage::delete($user->url);
                Storage::delete('public/img-profile/' . $user->hashname);
            }

            $image = $request->file('image');
            $hashName = $image->hashName();

            // Simpan foto profile
            $path = $image->store('public/img-profile');
            // Upload foto profil baru
            // $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            $url = asset('storage/img-profile/' . $hashName);
            $user->url = $url;
            $user->hashname = $hashName;
            $user->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diunggah.');
        }
        return redirect()->back()->with('error', 'Gagal mengunggah foto profil.');
    }

    public function getkecamatan(Request $request){

        $idkecamatan = $request->idkecamatan;
        // dd($idkecamatan);
        $desa = Wilayah::where('kode', 'like' , '%' . $idkecamatan . '%')
                ->WhereRaw('LENGTH(kode) = 13')
                ->get();

        foreach ($desa as $item) {
            echo  "<option value='$item->kode'>$item->nama</option>";
        }
    }

}
