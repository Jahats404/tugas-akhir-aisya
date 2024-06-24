<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\DetailKoran;
use App\Models\Koran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetugasKoranController extends Controller
{
    public function index()
    {
        $idUser = Auth::user()->id;
        $koranAdmin = Koran::where('user_id', $idUser)->get();
        $koran = Koran::all();
        $koranDiterima = Koran::where('status', 'Diterima')->get();
        $koranDitolak = Koran::where('status', 'Ditolak')->get();
        $koranTertunda = Koran::where('status', 'Tertunda')->get();
        return view('admin.olah-koran', compact('koran', 'koranAdmin', 'koranDiterima', 'koranDitolak', 'koranTertunda'));
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

    public function detail($id)
    {
        $idUser = Koran::find($id)->user_id;
        $dtKoran = DetailKoran::where('koran_id', $id)->get();

        return view('admin.detail-koran', compact('dtKoran'));
    }

    public function status(Request $request, $id)
    {
        // dd($request->status);
        $koran = Koran::findOrFail($id);
        $koran->status = $request->status;
        $koran->save();

        return redirect()->back()->with('success', 'Status berhasil diubah');
    }
}
