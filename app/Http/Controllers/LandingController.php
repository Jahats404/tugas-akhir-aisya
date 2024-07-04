<?php

namespace App\Http\Controllers;

use App\Models\Arpres;
use App\Models\Koran;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // $arpres = Arpres::where('status', 'Diterima')->get();
        $arprests = Arpres::with('detailArpres')->where('status', 'Diterima')->get();
        $korans = Koran::with('detailKoran')->where('status', 'Diterima')->get();
        // dd($korans);
        return view('landing', compact('arprests', 'korans'));
    }

    public function detail_arpres($id)
    {
        $arpres = Arpres::where('id_arpres', $id)
                ->where('status', 'Diterima')
                ->get();

        $arpres = $arpres[0];
        // dd($arpres);

        return view('detail-arpres', compact('arpres'));
    }

    public function detail_koran($id)
    {
        $koran = Koran::where('id', $id)
                ->where('status', 'Diterima')
                ->get();

        $koran = $koran[0];
        // dd($koran);

        return view('detail-koran', compact('koran'));
    }
}
