<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Arpres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetugasArpresController extends Controller
{
    public function index()
    {
        $idUser = Auth::user()->id;
        $arpresAdmin = Arpres::where('user_id', $idUser)->get();
        $arpres = Arpres::all();
        // dd($arpres);
        $arpresDiterima = Arpres::where('status', 'Diterima')->get();
        $arpresDitolak = Arpres::where('status', 'Ditolak')->get();
        $arpresTertunda = Arpres::where('status', 'Tertunda')->get();
        return view('admin.olah-arpres', compact('arpres', 'arpresAdmin', 'arpresDiterima', 'arpresDitolak', 'arpresTertunda'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nik' => 'required',
            'nama' => 'required',
            'wilayah' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
        ];
        $messages = [
            'nik.required' => 'Kolom NIK wajib diisi.',
            'nama.required' => 'Kolom nama wajib diisi.',
            'wilayah.required' => 'Kolom wilayah wajib diisi.',
            'kategori.required' => 'Kolom kategori wajib diisi.',
            'deskripsi.required' => 'Kolom deskripsi wajib diisi.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $arpres = new Arpres();
        // $arpres->user_id = 
        $arpres->nik = $request->nik;
        $arpres->nama = $request->nama;
        $arpres->wilayah = $request->wilayah;
        $arpres->kategori = $request->kategori;
        $arpres->deskripsi = $request->deskripsi;

        
    }
}
