<?php

namespace App\Http\Controllers\arsip;

use App\Http\Controllers\Controller;
use App\Models\Apribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PribadiController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $userKK = DB::table('masyarakat')
                ->select('kk')
                ->where('nik', $id)
                ->get();
        $kk = $userKK[0]->kk;

        $arpri = Apribadi::where('kk', $kk)->get();
        return view('masyarakat.arpri', compact('arpri'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Apribadi::$rules, Apribadi::$messages);
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
            $path = $image->store('public/img-arpri');

            // Dapatkan URL gambar yang diunggah
            $url = asset('storage/img-arpri/' . $hashName);

            // ID User
            $id = Auth::user()->id;
            // untuk mengambil data kk user yan login
            $userKK = DB::table('masyarakat')
                    ->select('kk')
                    ->where('nik', $id)
                    ->get();
            $kk = $userKK[0]->kk;

            // Tambahkan data ke tabel arsip_pendidikan
            $arpri = new Apribadi;
            $arpri->user_id = $id;
            $arpri->kategori = $request->input('kategori');
            $arpri->nama_arpri = $originalName;
            $arpri->deskripsi_arpri = $request->input('deskripsi_arpri');
            $arpri->url = $url;
            $arpri->hashname = $hashName;
            $arpri->kk = $kk;
            // $arpri->tanggal_upload = $request->input('tanggal_upload');
            $arpri->save();

            return redirect()->back()->with('success', 'Data berhasil di Upload');
        } catch (\Throwable $th) {
            return redirect()->back()->with('fail', 'Data berhasil di Upload');
        }
        // Validasi input

    }

    public function update(Request $request, $id_arpri)
    {

        $arsip = Apribadi::findOrFail($id_arpri);
        $arsip->kategori = $request->input('kategori');
        $arsip->deskripsi_arpri = $request->input('deskripsi_arpri');
        $arsip->save();

        return redirect()->back()->with('success', 'Arsip berhasil diperbarui.');
    }

    public function destroy($id_arpri)
    {
        $arsip = Apribadi::findOrFail($id_arpri);
        if (!empty($arsip->url)) {
            Storage::delete('public/img-arpri/' . $arsip->hashname);
        }
        $arsip->delete();

        return redirect()->back()->with('success', 'Arsip berhasil dihapus.');
    }
}
