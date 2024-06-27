<?php

namespace App\Http\Controllers\arsip;

use App\Http\Controllers\Controller;
use App\Models\Apendidikan;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PendidikanController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        // $id = Masyarakat::where('nik', $idUser)->first()->nik;
        // tampilkan arsip berdasarkan kk yang sama
        $userKK = DB::table('masyarakat')
                ->select('kk')
                ->where('nik', $id)
                ->get();
        $kk = $userKK[0]->kk;

        $arpen = Apendidikan::where('kk', $kk)->get();
        return view('masyarakat.arpen', compact('arpen'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Apendidikan::$rules, Apendidikan::$messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        };
    
        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();
        $hashName = $image->hashName();
        // Simpan gambar ke direktori yang diinginkan (misalnya: storage/app/public/images)
        $path = $image->store('public/img-arpen');
        
        // Dapatkan URL gambar yang diunggah
        $url = asset('storage/img-arpen/' . $hashName);
        
        // ID Masyarakat
        $id = Auth::user()->id;
        // untuk mengambil data kk user yan login
        $userKK = DB::table('masyarakat')
                ->select('kk')
                ->where('nik', $id)
                ->get();
        $kk = $userKK[0]->kk;
        
        // Tambahkan data ke tabel arsip_pendidikan
        $arpen = new Apendidikan;
        
        $arpen->user_id = $id;
        $arpen->kategori = $request->input('kategori');
        $arpen->jenjang = $request->input('jenjang');
        $arpen->nama_arpen = $originalName;
        $arpen->deskripsi_arpen = $request->input('deskripsi_arpen');
        $arpen->url = $url;
        $arpen->hashname = $hashName;
        $arpen->kk = $kk;
        // $arpen->tanggal_upload = $request->input('tanggal_upload');
        $arpen->save();

        return redirect()->back()->with('success', 'Data berhasil di Upload');
    }

    public function update(Request $request, $id_arpen)
    {
        $arsip = Apendidikan::findOrFail($id_arpen);
        $arsip->jenjang = $request->input('jenjang');
        $arsip->kategori = $request->input('kategori');
        $arsip->deskripsi_arpen = $request->input('deskripsi_arpen');
        $arsip->save();
    
        return redirect()->back()->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy($id_arpen){
        $arsip = Apendidikan::findOrFail($id_arpen);
        // $hashName = $image->hashName();
        // dd(('public/storage/img-arpen/' . $arsip->hashname));
        if (!empty($arsip->url)) {
            Storage::delete('public/img-arpen/' . $arsip->hashname);
            
        }
        $arsip->delete();
    
        return redirect()->back()->with('success', 'Arsip berhasil dihapus.');
    }
}
