<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\ActivityLog;
use Carbon\Carbon;
use App\Models\Kehadiran;
use App\Models\Sesi;
use App\Models\Murid;
use App\Models\Arsip;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;


class KelasController extends Controller
{
    // Method untuk menampilkan semua kelas
    public function index()
    {
        $tahunAjaran = TahunAjaran::orderby('tahun_mulai','desc')->orderBy('kode_ta','desc')->get();
        // $kelas = Kelas::orderBy('id_kelas')->paginate(6);
        $kelas = Kelas::all();
        $guru= Guru::all();
        return view('kelas.index', [
            'kelas'=>$kelas,
            'tahunAjaran' => $tahunAjaran,
            'guru' => $guru
        ]);
    }
    public function getKelasByTahunAjaran(Request $request)
    {
        // Method untuk kelas/index.blade.php
        // method ini untuk ngembalikan data kelas bedasarkan id_ta yang dipilih user
        $id_ta = $request->input('id_ta');
        $kelasList = Kelas::with('guru', 'tahunAjaran')
            ->where('id_ta', $id_ta)
            ->get();
    
        $response = $kelasList->map(function($kelas) {
            return [
                'id_kelas' => $kelas->id_kelas,
                'id_ta' => $kelas->id_ta,
                'nama_kelas' => $kelas->nama_kelas,
                'id_guru' => $kelas->guru->id_guru,
                'nama_guru' => $kelas->guru ? $kelas->guru->nama_guru : 'Guru tidak ditemukan',
                'kode_ta' => $kelas->tahunAjaran ? $kelas->tahunAjaran->kode_ta : 'Tahun ajaran tidak ditemukan',
            ];
        });
    
        return response()->json($response);
    }
    



public function search(Request $request, $id_ta) 
{
    $query = Kelas::where('id_ta', $id_ta)->with('guru');

    // Memeriksa apakah ada parameter pencarian
    if ($request->has('q')) {
        $query->where('nama_kelas', 'LIKE', '%' . $request->query('q') . '%');
    }

    $data = $query->orderBy('id_kelas', 'asc')->get();
    // if($data){
    //     return response()->json("Data Kelas Tidak Ditemukan");
    // }
    return response()->json($data);
}



        
    // Method untuk menampilkan form tambah kelas
    public function create()
    {
        $guru= Guru::all();
        return view('kelas.create', compact('guru'));
    }

    // Method untuk menyimpan data kelas yang baru
    public function store(Request $request)
    {  
        $request->validate([
            'nama_kelas' => 'required',
            'id_guru' => 'required',
            'id_ta' => 'required'
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'id_guru' => $request->id_guru,
            'id_ta' => $request->id_ta
           
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Data Kelas Baru: ' . $request->nama_kelas . ' Tahun Ajaran : ' .$kelas->tahunAjaran->kode_ta, // Deskripsi aktivitas
            'object_id' => $kelas->id_kelas, // ID murid yang ditambahkan
            'object_type' => 'App\Models\Kelas', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
        
        // Redirect ke halaman yang ditentukan setelah menyimpan data
        return redirect()->route('kelas.index')->with(['success' => 'Data Berhasil Disimpan']);
    }


    // Method untuk menampilkan form edit kelas
    public function edit($id_kelas)
    { 
        $guru = Guru::all();
        $kelas = Kelas::find($id_kelas);
        
        if (!$kelas) {
            return redirect()->route('kelas.index')
                ->with('error_message', 'Kelas dengan id '.$id_kelas.' tidak ditemukan');
        }
        
        return view('kelas.edit', [
            'kelas' => $kelas,
            'guru' => $guru // Mengirimkan data guru ke view
        ]);
        
    }
   
    
    
    public function update(Request $request, $id_kelas)
    {
        $kelas = Kelas::findorfail($id_kelas);
        $request->validate([
            'edit_nama_kelas' => 'required',
            'edit_id_guru' => 'required',
            'edit_id_ta' => 'required',
        ]);

        // Simpan data lama untuk log aktivitas
        $oldNamaKelas = $kelas->nama_kelas;
        $oldTahunAjaran = $kelas->tahunAjaran->kode_ta ?? 'Tidak Ada';

        $time = Carbon::now()->format('Y-m-d H:i:s');
        
        // dd($kelas);
        $kelas->nama_kelas = $request->input('edit_nama_kelas');
        $kelas->id_guru = $request->input('edit_id_guru');
        $kelas->id_ta = $request->input('edit_id_ta');
        $kelas->save();
        
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Data Kelas: ' . $oldNamaKelas. ' Tahun Ajaran : '. $oldTahunAjaran , // Deskripsi aktivitas
            'object_id' => $id_kelas, // ID murid yang diperbarui
            'object_type' => 'App\Models\Kelas', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        return response()->json(['success' => 'Data kelas berhasil diperbarui']);
    }
    

    // Method untuk menghapus data kelas
    public function destroy(Request $request, $id_kelas)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        if (!$kelas) {
            return redirect()->back()
            ->with('error_message', 'Kelas dengan id '.$id_kelas.' tidak ditemukan');
        }

        $oldNamaKelas = $kelas->nama_kelas;
        $oldTahunAjaran = $kelas->tahunAjaran->kode_ta ?? 'Tidak Ada';
        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus Data Kelas: ' . $oldNamaKelas. ' Tahun Ajaran : '. $oldTahunAjaran , // Deskripsi aktivitas
            'object_id' => $id_kelas, // ID murid yang diperbarui
            'object_type' => 'App\Models\Kelas', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        $kelas->delete();
        return redirect()->back()->with(['success' => 'Data Berhasil Dihapus!']);
    }

   

    public function teskehadiran(Request $request)
    {
        $id_sesi = $request->id_sesi_inputan;
        $id_murid = $request->id_murid;

        $data = Kehadiran::where('id_sesi',$id_sesi)
                        ->where('id_murid',$id_murid)
                        ->get();
        
        return response()->json($data);
    }

    
    public function searchguru(Request $request)
{
    $search = $request->get('q');
    $guru = Guru::where('nama_guru', 'LIKE', "%$search%")->orderby('nama_guru')->get();

    return response()->json($guru);
}

public function show($id_kelas, $id_ta)
{
    // Mengambil data kelas berdasarkan id_kelas dan id_ta
    $kelas = Kelas::with('murids')
                ->where('id_kelas', $id_kelas)
                ->where('id_ta', $id_ta)
                ->first();
  
    // Pastikan untuk memeriksa jika kelas ada
    if (!$kelas) {
        return redirect()->back()->with('error', 'Kelas tidak ditemukan.');
    }
    // Mengambil murid yang masih berada di kelas yang diinput berdasarkan arsip, 
    // agar murid yang sudah pindah ke tahun ajaran baru tidak ditampilkan di daftar kelas lama
    $arsip = Arsip::where('id_kelas', $id_kelas)
                ->where('id_ta', $id_ta) // Ini hanya untuk tahun ajaran yang dipilih
                ->with('murids')
                ->get()
                ->unique('id_murid');

    $tes = Arsip::where('id_kelas',$id_kelas)->where('id_ta',$id_ta)->with('murids')->get()->unique('id_murid');
    
    // dd($arsip->count() , $id_kelas, $id_ta,$tes->count()); 

    // Mengembalikan view dengan data kelas dan arsip murid (tanpa duplikat)
    return view('kelas.show', compact('kelas', 'arsip'));
}

public function kehadiran($id_kelas, $id_ta)
{
    // METHOD UNTUK MENAMPILKAN RINCIAN.BLADE.PHP PADA FOLDER KELAS
    $murids = Murid::where('id_kelas', $id_kelas)->where('id_ta', $id_ta)->get();
    $kelas = Kelas::where('id_kelas', $id_kelas)->where('id_ta', $id_ta)->first();

    // $sesi = Sesi::where('id_ta',$id_ta)->get();
    

    // dd("Data ta :", $id_ta);
    $sesi = Sesi::where('id_ta',$id_ta)->pluck('id_sesi')->toArray();
    if (!$kelas) {
        return abort(404); // Tampilkan halaman error 404 jika kelas tidak ditemukan
    }

    // Ambil id murid untuk query kehadiran
    $id_murids = $murids->pluck('id_murid')->toArray();
     $kehadiran = Kehadiran::whereIn('id_murid', $id_murids)
                       ->where('id_kelas', $id_kelas)
                    //    ->whereIn('id_sesi', $sesi)
                       ->get();
    
    // dd("Data",$kehadiran);

    return view('kelas.rincian', compact(
 
        'sesi', 
        'kelas',
        'murids',
        'kehadiran'
    ));
}

    
}
