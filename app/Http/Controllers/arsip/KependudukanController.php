<?php

namespace App\Http\Controllers\arsip;

use App\Http\Controllers\Controller;
use App\Models\Akependudukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KependudukanController extends Controller
{
    public function index()
    {
        $arkep = Akependudukan::all();
        return view('masyarakat.arkep', compact('arkep'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Akependudukan::$rules, Akependudukan::$messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        };
        try {
    
            $image = $request->file('image');
            $originalName = $image->getClientOriginalName();
            $hashName = $image->hashName();
            // Simpan gambar ke direktori yang diinginkan (misalnya: storage/app/public/images)
            $path = $image->store('public/img-arkep');
            // Dapatkan URL gambar yang diunggah
            $url = asset('storage/img-arkep/' . $hashName);
            // Kode Otomatis
            $kependidikan = Akependudukan::all();
            $LastKependudukan = Akependudukan::orderBy('id_arkep','desc')->first();
            $newIdKependudukan = $LastKependudukan ? (int) substr($LastKependudukan->id_arkep,1) + 1 : 1;
            $newIdFormat = 'K'. str_pad($newIdKependudukan,3,'0', STR_PAD_LEFT);
            // ID Masyarakat
            $id = Auth::user()->id;
            // ambil data kk user yang login
            $userKK = DB::table('users')
                    ->select('kk')
                    ->where('id', $id)
                    ->get();
            $kk = $userKK[0]->kk;
            // Tambahkan data ke tabel arsip_pendidikan
            $arkep = new Akependudukan;
            $arkep->user_id = $id;
            $arkep->kategori = $request->input('kategori');
            $arkep->nama_arkep = $originalName;
            $arkep->deskripsi_arkep = $request->input('deskripsi_arkep');
            $arkep->url = $url;
            $arkep->hashname = $hashName;
            $arkep->kk = $kk;
            // $arkep->tanggal_upload = $request->input('tanggal_upload');
            $arkep->save();
    
            return redirect()->back()->with('success', 'Data berhasil di Upload');
        } catch (\Throwable $th) {
            return redirect()->back()->with('fail', 'Data gagal di Upload');
        }
        // Validasi input
        
    }

    public function update(Request $request, $id_arkep){
    
        $arsip = Akependudukan::findOrFail($id_arkep);
        $arsip->kategori = $request->input('kategori');
        $arsip->deskripsi_arkep = $request->input('deskripsi_arkep');
        $arsip->save();
    
        return redirect()->back()->with('success', 'Arsip berhasil diperbarui.');
        }

    public function destroy($id_arkep){
    $arsip = Akependudukan::findOrFail($id_arkep);
    if (!empty($arsip->url)) {
        Storage::delete('public/img-arkep/' . $arsip->hashname);
        
    }
    $arsip->delete();

    return redirect()->back()->with('success', 'Arsip berhasil dihapus.');
    }
}
