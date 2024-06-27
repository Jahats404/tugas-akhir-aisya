<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Akependudukan;
use App\Models\Akesehatan;
use App\Models\Apendidikan;
use App\Models\Apribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
        public function dashboardA()
        {
                $id = Auth::user()->id;
                $countkependudukan = Akependudukan::count();
                $countpendidikan = Apendidikan::count();
                $countkesehatan = Akesehatan::count();
                $countpribadi = Apribadi::count();
                $kota = '33.01';

                $data = [
                        'labels' => ['Pendidikan', 'Kesehatan', 'Kependudukan', 'Pribadi'],
                        'datasets' => [
                                [
                                        'data' => [$countkependudukan, $countpendidikan, $countkesehatan, $countpribadi], // Contoh data
                                        'backgroundColor' => [
                                                '#FF6384',
                                                '#36A2EB',
                                                '#FFCE56',
                                                '#4BC0C0'
                                        ]
                                ]
                        ]
                ];

                //query untuk menampilkan seluruh nama di tabel wilayah dengan panjang kodenya 8
                $namaKecamatan = DB::table('wilayah')
                        ->select('nama')
                        ->where('kode', 'like', '%' . $kota . '%')
                        // ->orderBy('nama', 'asc')
                        ->WhereRaw('LENGTH(kode) = 8')
                        ->get();
                $kodeKecamatan = DB::table('wilayah')
                        ->select('kode')
                        ->where('kode', 'like', '%' . $kota . '%')
                        // ->orderBy('nama', 'asc')
                        ->WhereRaw('LENGTH(kode) = 8')
                        ->get();
                //query untuk menampilkan total
                $totalKecamatan = DB::table('wilayah')
                        ->select('total')
                        ->where('kode', 'like', '%' . $kota . '%')
                        ->WhereRaw('LENGTH(kode) = 8')
                        ->get();
                // dd($totalKecamatan);

                $namaDesa = DB::table('wilayah')
                        ->select('nama')
                        ->where('kode', 'like', '%' . $kota . '%')
                        // ->orderBy('nama', 'asc')
                        ->WhereRaw('LENGTH(kode) = 13')
                        ->get();
                // dd($namaDesa);
                //query untuk menampilkan total
                $totalDesa = DB::table('wilayah')
                        ->select('total')
                        ->where('kode', 'like', '%' . $kota . '%')
                        ->WhereRaw('LENGTH(kode) = 8')
                        ->get();

                $desa = DB::table('wilayah')
                        ->where('kode', 'like', '%' . $kota . '%')
                        ->orderBy('nama', 'asc')
                        ->WhereRaw('LENGTH(kode) = 13')
                        ->get();

                $cekdesaa = '33.01.02';
                $cekdesa = DB::table('wilayah')
                        ->select('nama')
                        ->where('kode', 'like', '%' . $cekdesaa . '%')
                        // ->orderBy('nama', 'asc')
                        ->WhereRaw('LENGTH(kode) = 13')
                        ->get();
                // ========================================  MAPS   ========================================================================
                $cekJumlah = DB::table('wilayah')
                        ->where('kode', 'like', '%' . $kota . '%')
                        ->whereRaw('length(kode) = 8')
                        ->get();
                return view('admin.index', compact('data', 'kodeKecamatan', 'totalKecamatan', 'totalDesa', 'namaDesa', 'countkependudukan', 'countpendidikan', 'countkesehatan', 'countpribadi', 'namaKecamatan', 'desa', 'cekJumlah'));
        }

        public function dashboardM()
        {
                $id = Auth::user()->id;
                $countkependudukan = Akependudukan::where('user_id', $id)->count();
                $countpendidikan = Apendidikan::where('user_id', $id)->count();
                $countkesehatan = Akesehatan::where('user_id', $id)->count();
                $countpribadi = Apribadi::where('user_id', $id)->count();
                $countkoran = Apribadi::where('user_id', $id)->count();
                $countpribadi = Apribadi::where('user_id', $id)->count();

                $data = [
                        'labels' => ['Pendidikan', 'Kesehatan', 'Kependudukan', 'Pribadi'],
                        'datasets' => [
                                [
                                        'data' => [$countkependudukan, $countpendidikan, $countkesehatan, $countpribadi], // Contoh data
                                        'backgroundColor' => [
                                                '#FF6384',
                                                '#36A2EB',
                                                '#FFCE56',
                                                '#4BC0C0'
                                        ]
                                ]
                        ]
                ];

                return view('masyarakat.index', compact('data', 'countkependudukan', 'countpendidikan', 'countkesehatan', 'countpribadi'));
        }

        private function getDesaData($kode)
        {
                // Menampilkan data desa yang ada di kecamatan yang dipilih
                $desa = DB::table('wilayah')
                        ->where('kode', 'like', '%' . $kode . '%')
                        ->whereRaw('length(kode) = 13')
                        ->get();

                // Ambil nama kecamatan yang dipilih
                $ambilNama = DB::table('wilayah')
                        ->select('nama')
                        ->where('kode', $kode)
                        ->get();

                $namaKecamatan = $ambilNama[0]->nama;

                return compact('desa', 'namaKecamatan');
        }

        public function adipala()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.03'));
        }

        public function kesugihan()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.02'));
        }

        public function dayeuhluhur()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.16'));
        }

        public function wanareja()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.15'));
        }

        public function majenang()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.14'));
        }

        public function cimanggu()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.13'));
        }

        public function cipari()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.18'));
        }

        public function karangpucung()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.12'));
        }

        public function sidareja()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.11'));
        }

        public function kedungreja()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.01'));
        }

        public function gandrungmangu()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.10'));
        }

        public function patimuan()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.19'));
        }

        public function bantarsari()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.20'));
        }

        public function kampunglaut()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.24'));
        }

        public function kawunganten()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.09'));
        }

        public function jeruklegi()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.08'));
        }

        public function cilacaptengah()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.22'));
        }

        public function nusakambangan()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.22'));
        }

        public function cilacaputara()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.23'));
        }

        public function maos()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.07'));
        }

        public function sampang()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.17'));
        }

        public function kroya()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.06'));
        }

        public function binangun()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.04'));
        }

        public function nusawungu()
        {
                return view('admin.data-desa', $this->getDesaData('33.01.05'));
        }
}
