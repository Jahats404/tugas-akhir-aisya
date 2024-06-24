<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\DetailKoran;
use App\Models\Koran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MasyarakatKoranController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $koran = Koran::where('user_id', $user)->get();
        return view('masyarakat.olah-koran', compact('koran'));
    }

    public function store(Request $request)
    {
        $rules = [
            'penerbit' => 'required',
            'deskripsi' => 'required',
            'images' => 'required',
            'images.*' => 'mimes:jpeg,png,jpg|max:2048',
        ];
        
        $messages = [
            'penerbit.required' => 'Penerbit tidak boleh kosong!',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong!',
            'images.required' => 'Foto tidak boleh kosong!',
            'images.*.mimes' => 'Dokumen harus berformat jpeg, png, atau jpg!',
            'images.*.max' => 'Ukuran Dokumen maksimal 2MB!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $user = Auth::user()->id;
        $koran = new Koran();
        $koran->user_id = $user;
        $koran->penerbit = $request->penerbit;
        $koran->deskripsi = $request->deskripsi;
        // $koran->image = $originalName;
        // $koran->path = $path;
        $koran->status = 'Tertunda';
        $koran->save();

        $koran_id = Koran::orderBy('id', 'desc')->first()->id;
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $originalName = $image->getClientOriginalName();
                $hashName = $image->hashName();
                $path = $image->store('public/koran');
                $path = asset('storage/koran/' . $hashName);

                $dtKoran = new DetailKoran();
                $dtKoran->koran_id = $koran_id;
                $dtKoran->image = $originalName;
                $dtKoran->path = $path;
                $dtKoran->save();
            }
        }

        return redirect()->back()->with('success', 'Arsip Koran berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'penerbit' => 'required',
            'deskripsi' => 'required',
        ];
        
        $messages = [
            'penerbit.required' => 'Penerbit tidak boleh kosong!',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $koran = Koran::findOrFail($id);
        $koran->penerbit = $request->penerbit;
        $koran->deskripsi = $request->deskripsi;
        $koran->save();

        return redirect()->back()->with('success', 'Arsip koran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $dtKoran = DetailKoran::where('koran_id', $id)->get();

        foreach ($dtKoran as $detail) {
            if (!empty($detail->path)) {
                $hashName = basename($detail->path);
                Storage::delete('public/koran/' . $hashName);
            }
        }
        
        DetailKoran::where('koran_id', $id)->delete();

        $koran = Koran::findOrFail($id);
        $hashName = basename($koran->path);
        
        $koran->delete();

        return redirect()->back()->with('success', 'Arsip koran berhasil dihapus');
    }

// ====================================== DETAIL KORAN =================================

    public function detail($id)
    {
        $idUser = Koran::find($id)->user_id;
        // $user = User::
        $dtKoran = DetailKoran::where('koran_id', $id)->get();
        
        return view('masyarakat.detail-koran', compact('dtKoran'));
    }

    public function storeImage(Request $request)
    {
        $rules = [
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ];
        $messages = [
            'image.required' => 'Foto tidak boleh kosong!',
            'image.mimes' => 'Dokumen harus berformat jpeg, png, atau jpg!',
            'image.max' => 'Ukuran Dokumen maksimal 2MB!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $dtKoran = new DetailKoran();

        $idUser = Auth::user()->id;
        $idKoran = Koran::where('user_id', $idUser)->first()->id;

        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();
        $hashName = $image->hashName();
        // Simpan gambar ke direktori yang diinginkan (misalnya: storage/app/public/images)
        $path = $image->store('public/koran');

        // Dapatkan URL gambar yang diunggah
        $path = asset('storage/koran/' . $hashName);
        $dtKoran->koran_id = $idKoran;
        $dtKoran->image = $originalName;
        $dtKoran->path = $path;
        $dtKoran->save();

        return redirect()->back()->with('success', 'Foto berhasil ditambahkan');

    }
    
    public function destroyImage($id)
    {
        $dtKoran = DetailKoran::findOrFail($id);
        $hashName = basename($dtKoran->path);
        if (!empty($dtKoran->path)) {
            Storage::delete('public/koran/' . $hashName);
        }
        $dtKoran->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus');
    }
}
