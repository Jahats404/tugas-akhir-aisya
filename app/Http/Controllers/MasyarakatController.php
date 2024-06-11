<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    public function index()
        {
                $masyarakat = User::whereRaw('length(nik) = 16')->get();
                return view('admin.daftar-masyarakat', compact('masyarakat'));
        }

        public function destroy(Request $request, $id)
        {
                $userID = User::findOrFail($id)->delete();
                return redirect()->back()->with('success', 'Berhasil menghapus Masyarakat');
        }
}
