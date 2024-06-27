<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Arpres;
use App\Models\DetailArpres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MasyarakatArpresController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $arpres = Arpres::where('user_id', $user)->get();

        return view('masyarakat.olah-arpres', compact('arpres'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $rules = [
            'nama' => 'required',
            'wilayah' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required|string',
            'images' => 'required',
            'images.*' => 'mimes:jpeg,png,jpg',
        ];
        $messages = [
            'nama.required' => 'Nama tidak boleh kosong!',
            'wilayah.required' => 'Wilayah tidak boleh kosong!',
            'kategori.required' => 'Kategori tidak boleh kosong!',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong!',
            'images.required' => 'Foto tidak boleh kosong!',
            'images.*.mimes' => 'Dokumen harus berformat jpeg, png, atau jpg!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $user = Auth::user()->id;
        $arpres = new Arpres();
        $arpres->user_id = $user;
        $arpres->nama = $request->nama;
        $arpres->wilayah = $request->wilayah;
        $arpres->deskripsi = $request->deskripsi;
        $arpres->kategori = $request->kategori;
        $arpres->status = '-';
        $arpres->save();

        $arpres_id = Arpres::orderBy('id_arpres', 'desc')->pluck('id_arpres')->first();
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $originalName = $image->getClientOriginalName();
                $hashName = $image->hashName();
                $path = $image->store('public/arpres');
                $path = asset('storage/arpres/' . $hashName);

                $dtArpres = new DetailArpres();
                $dtArpres->arpres_id = $arpres_id;
                $dtArpres->image = $originalName;
                $dtArpres->path = $path;
                $dtArpres->save();
            }
        }

        return redirect()->back()->with('success', 'Arsip Prestasi berhasil ditambahkan');
    }

    public function ajukan($id)
    {
        $arpres = Arpres::findOrFail($id);
        $arpres->status = 'Tertunda';
        $arpres->save();

        return redirect()->back()->with('success', 'Berhasil diajukan');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama' => 'required',
            'wilayah' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required|string',
        ];
        $messages = [
            'nama.required' => 'Nama tidak boleh kosong!',
            'wilayah.required' => 'Wilayah tidak boleh kosong!',
            'kategori.required' => 'Kategori tidak boleh kosong!',
            'deskripsi.required' => 'Deskripsi tidak boleh kosong!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $arpres = Arpres::findOrFail($id);
        $arpres->nama = $request->nama;
        $arpres->wilayah = $request->wilayah;
        $arpres->deskripsi = $request->deskripsi;
        $arpres->kategori = $request->kategori;
        $arpres->save();

        return redirect()->back()->with('success', 'Arsip Prestasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $dtArpres = DetailArpres::where('arpres_id', $id)->get();

        foreach ($dtArpres as $detail) {
            if (!empty($detail->path)) {
                $hashName = basename($detail->path);
                Storage::delete('public/arpres/' . $hashName);
            }
        }
        
        DetailArpres::where('arpres_id', $id)->delete();

        $arpres = Arpres::findOrFail($id);
        $hashName = basename($arpres->path);
        
        $arpres->delete();

        return redirect()->back()->with('success', 'Arsip Prestasi berhasil dihapus');
    }

    // ====================================== DETAIL KORAN =================================

    public function detail($id)
    {
        $idUser = Arpres::find($id)->user_id;
        // $user = User::
        $dtArpres = DetailArpres::where('arpres_id', $id)->get();
        
        return view('masyarakat.detail-arpres', compact('dtArpres'));
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

        $dtArpres = new DetailArpres();

        $idUser = Auth::user()->id;
        $idArpres = Arpres::where('user_id', $idUser)->first()->id_arpres;

        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();
        $hashName = $image->hashName();
        // Simpan gambar ke direktori yang diinginkan (misalnya: storage/app/public/images)
        $path = $image->store('public/arpres');

        // Dapatkan URL gambar yang diunggah
        $path = asset('storage/arpres/' . $hashName);
        $dtArpres->arpres_id = $idArpres;
        $dtArpres->image = $originalName;
        $dtArpres->path = $path;
        $dtArpres->save();

        return redirect()->back()->with('success', 'Foto berhasil ditambahkan');

    }
    
    public function destroyImage($id)
    {
        $dtArpres = DetailArpres::findOrFail($id);
        $hashName = basename($dtArpres->path);
        if (!empty($dtArpres->path)) {
            Storage::delete('public/arpres/' . $hashName);
        }
        $dtArpres->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus');
    }
}
