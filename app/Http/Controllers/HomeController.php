<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\PelanggaranSiswa;
use App\Models\Murid;
use App\Models\ActivityLog;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlahMurid = DB::table('murids')->count('nama_murid');
        $jumlahGuru = DB::table('gurus')->count('nama_guru');
        $jumlahAdmin = DB::table('users')->count('name');
        $jumlahWali = DB::table('ortus')->count('nama_ortu');
        $tglskrng = Carbon::today()->format('d-m-y');

        $most_pelanggaran = PelanggaranSiswa::select('id_murid', DB::raw('COUNT(*) as total_pelanggaran'))
        ->groupBy('id_murid')
        ->orderByDesc('total_pelanggaran')
        ->first();
    
        $murid = null;
        if ($most_pelanggaran) {
                // Mengambil data murid berdasarkan `id_murid` dari tabel murid
                $murid = Murid::find($most_pelanggaran->id_murid);
        }

        $total_pelanggaran = $most_pelanggaran ? $most_pelanggaran->total_pelanggaran : 0;

        $logs =  ActivityLog::orderby('id',"desc")->with(['actor', 'object'])->paginate(6);
       
        return view('home', compact(
            'jumlahMurid',
            'jumlahGuru',
            'jumlahAdmin',
            'jumlahWali',
            'tglskrng',
            'total_pelanggaran',
            'murid',
            'logs',


        ));
    }
  
}



