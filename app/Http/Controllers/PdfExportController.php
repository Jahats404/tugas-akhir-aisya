<?php

namespace App\Http\Controllers;

use App\Models\Arpres;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; // Pastikan facade PDF digunakan

class PdfExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        // Pastikan request 'tanggal' diisi dengan format 'YYYY-MM'
        $bulan = date('m', strtotime($request->tanggal));
        $tahun = date('Y', strtotime($request->tanggal));

        $data = Arpres::whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();
        // $jumlahPerKategori = Arpres::select('kategori', \DB::raw('count(*) as total'))
        //     ->whereMonth('created_at', $bulan)
        //     ->whereYear('created_at', $tahun)
        //     ->groupBy('kategori')
        //     ->get();

        $olahraga = Arpres::where('kategori', 'Olahraga')->count();
        $akademik = Arpres::where('kategori', 'Akademik')->count();
        $kesenian = Arpres::where('kategori', 'Kesenian')->count();
        $pengabdian = Arpres::where('kategori', 'Pengabdian')->count();

        $pdf = PDF::loadView('admin.export-pdf', compact('data', 'olahraga','akademik','kesenian','pengabdian'))->setPaper('a4', 'landscape');;

        return $pdf->stream('arsip_histori_prestasi.pdf');
    }
}
