<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'home'
        ]);
        // $this->middleware('auth')->only('logout', 'home');
        // $this->middleware('verified')->only('home');
    }

    /**
     * Display a registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        $kota = '33.01';
        $kecamatan = Wilayah::where('kode', 'like', '%' . $kota . '%')
                ->orderBy('nama', 'asc')
                ->WhereRaw('LENGTH(kode) = 8')
                ->get();
        
        $desa = Wilayah::where('kode', 'like', '%' . $kota . '%')
                ->orderBy('nama', 'asc')
                ->WhereRaw('LENGTH(kode) = 13')
                ->get();
        return view('auth.register', compact('kecamatan', 'desa'));
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), User::$rules, User::$messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        //untuk mengambil kode desa yang di inputkan
        $kodeDesa = $request->desa;
        $kodeKecamatan = $request->kecamatan;
        
        //untuk mengubah setiap wilayah jika total NULL akan di ubah menjadi 0
        $ubahNull = DB::table('wilayah')
                ->where('kode', 'like', '%' . '33.01' . '%')
                ->where('total', NULL)
                ->update(['total' => 0]);

        //mengecek total masyarakat mendaftar di desa tersebut
        $showTotalkec = DB::table('wilayah')
                ->where('kode', $kodeKecamatan)
                ->get();

        //mengecek total masyarakat mendaftar di desa tersebut
        $showTotaldes = DB::table('wilayah')
                ->where('kode', $kodeDesa)
                ->get();
        //menambah jumlah total desa
        $totalafterDes = $showTotaldes[0]->total + 1;
        //menambah jumlah total kecamatan
        $totalafterKec = $showTotalkec[0]->total + 1;
        
        //untuk mengupdate data total dari kecamatan
        $updateTotalKec = DB::table('wilayah')
                ->where('kode', $kodeKecamatan)
                ->update(['total' => $totalafterKec]);
        //untuk mengupdate data total dari desa
        $updateTotalDes = DB::table('wilayah')
                ->where('kode', $kodeDesa)
                ->update(['total' => $totalafterDes]);
        

        // mengambil nama kecamatan berdasarkan kode
        $namakecamatan = DB::table('wilayah')
                ->select('nama')
                ->where('kode', $kodeKecamatan)
                ->get();
        // mengambil nama kecamatan berdasarkan kode
        $namaDesa = DB::table('wilayah')
                ->select('nama')
                ->where('kode', $kodeDesa)
                ->get();
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nik' => $request->nik,
            'kecamatan' => $namakecamatan[0]->nama,
            'desa' => $namaDesa[0]->nama,
            'role_id' => 2,
            'kk' => $request->kk,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('verification.notice');
    }

    /**
     * Display a login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        // $credentials = $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required'
        // ]);

        // if(Auth::attempt($credentials))
        // {
        //     $request->session()->regenerate();
        //     return redirect()->route('admin.dashboard');
        // }

        // return back()->withErrors([
        //     'email' => 'Your provided credentials do not match in our records.',
        // ])->onlyInput('email');
        Session::flash('email', $request->input('email'));
    
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'masukan email',
            'password.required' => 'masukan password'
        ]);

        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    
        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role_id == '1') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role_id == '2') {
                return redirect()->route('masyarakat.dashboard');
            }
        }
        Session::flash('gagal', 'Email atau Password Salah');
        return redirect('/login');
    } 
    
    /**
     * Display a home to authenticated & verified users.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('admin.index');
    } 
    
    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }

    public function getkecamatan(Request $request){

        $idkecamatan = $request->idkecamatan;
        // dd($idkecamatan);
        $desa = Wilayah::where('kode', 'like' , '%' . $idkecamatan . '%')
                ->WhereRaw('LENGTH(kode) = 13')
                ->get();

        foreach ($desa as $item) {
            echo  "<option value='$item->kode'>$item->nama</option>";
        }
    }
}
