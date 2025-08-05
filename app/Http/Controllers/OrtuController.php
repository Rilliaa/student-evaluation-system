<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Charts\GrafikLineChart;
use App\Charts\KehadiranMuridChart;
use Illuminate\Support\Facades\Hash;
use App\Models\Ortu;
use Carbon\Carbon;
use App\Models\ActivityLog;
use App\Models\Murid;
use App\Models\Arsip;
use App\Models\TahunAjaran;
use App\Models\Roles;
use App\Models\Kelas;
use App\Models\PelanggaranSiswa;
use App\Models\PrestasiSiswa;
use App\Models\JamPelajaran;
use Illuminate\Support\Facades\Auth;


class OrtuController extends Controller
{
    // Method untuk menampilkan semua data ortu
    public function index()
    {
        // untuk mengatur ortus/index.blade.php
        $ortus = Ortu::with(['murids' => function($query) {
            $query->orderBy('id_kelas');
        }])->paginate(10); 
        
        $roles = Roles::all();
        $murids = Murid::all();
        $kelas = Kelas::all();
    
        return view('ortus.index', [
            'ortus' => $ortus,
            'roles' => $roles,
            'murids' => $murids,
            'kelas' => $kelas,
        ]);
    }
    public function livesearch(Request $request)
    {
        // untuk livesearch di ortus/index.blade.php
        $query = $request->input('q');

        $ortus = Ortu::with(['roles', 'murids.kelas'])
            ->where('nama_ortu', 'LIKE', "%$query%")
            ->orderBy('nama_ortu')
            ->get();

        return response()->json(['ortus' => $ortus]);
    }
    

    // Method untuk menampilkan form tambah ortu
    public function create()
    {
        // untuk mengatur tampilan ortus/create.blade.php
        $murids = Murid::all();
        $roles = Roles::all();
        $ortus = Ortu::with('murids.kelas')->get();
        return view('ortus.create', compact('murids', 'roles','ortus'));
    }

    // Method untuk menyimpan data ortu yang baru
    public function store(Request $request)
    {
    //    untuk penyimpanan data dari form ke database
        
        $request->validate([
            'nama_ortu' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            // 'email' => 'required',
            'no_hp' => 'required',
            'role' => 'required',
            'id_murid' => 'required'
          
            
        ]);
        $id_murid = $request->input('id_murid');
        $murid = Murid::find($id_murid);

        $ortu = Ortu::create([
            'nama_ortu' => $request->nama_ortu,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat, 
            'email' => $request->email, 
            'no_hp' => $request->no_hp, 
            'role' => $request->role,
            'id_murid' => $request->id_murid,
            'username' => $murid->nisn,
            'password' =>  Hash::make($murid->nisn),
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan data wali murid baru: ' . $request->nama_ortu, // Deskripsi aktivitas
            'object_id' => $ortu->id_ortu, // ID murid yang ditambahkan
            'object_type' => 'App\Models\Ortu', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
        

        // Redirect ke halaman yang ditentukan setelah menyimpan data
        return redirect()->route('ortus.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // Method untuk menampilkan detail ortu

    // Method untuk menampilkan form edit ortu
    public function edit($id_ortu)
    {
        // mengatur tampilan ortus/edit.blade.php
        $roles = Roles::all();
        $ortu = Ortu::with('murids')->find($id_ortu);   
        $murids = Murid::all();
        if (!$ortu) {
            return redirect()->route('ortus.index')
                ->with('error_message', 'Wali Murid dengan id '.$id_ortu.' tidak ditemukan');
        }
        return view('ortus.edit', [
            'ortu' => $ortu,
            'murids' => $murids,
            'roles' => $roles
        ]);
    }

    // Method untuk menyimpan perubahan data ortu yang diedit
    public function update(Request $request, $id_ortu)
    {
        // Cari data ortu berdasarkan id_ortu
        $ortu = Ortu::findOrFail($id_ortu);
    
        // Validasi data dari form
        $request->validate([
            'nama_ortu' => 'required',
            'id_murid' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            // 'email' => 'required',
            'no_hp' => 'required',
            'role' => 'required'
        ]);
    
    
        $id_murid_lama = $ortu->id_murid;
        $id_murid_baru = $request->id_murid;

    // Jika id_murid berubah, kita ganti username dan password
        
        if ($id_murid_lama != $id_murid_baru) {
            $murid = Murid::find($id_murid_baru);
            $ortu->update([
                'username' => $murid->nisn,
                'password' => Hash::make($murid->nisn)
            ]);
        }
    
        $oldData = $ortu->toArray();

        // Update data ortu lainnya
        $ortu->update([
            'nama_ortu' => $request->nama_ortu,
            'id_murid' => $id_murid_baru,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role' => $request->role
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui data guru: ' . $oldData['nama_ortu'], // Deskripsi aktivitas
            'object_id' => $id_ortu, // ID murid yang diperbarui
            'object_type' => 'App\Models\Ortu', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        // Redirect ke halaman ortus.index setelah update
        return redirect()->route('ortus.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    
    public function destroy($id_ortu): RedirectResponse
    {
        
        $ortu = Ortu::findOrFail($id_ortu);
        
        $oldData = $ortu->toArray();
        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus data wali: ' . $oldData['nama_ortu'], // Deskripsi aktivitas
            'object_id' => $id_ortu, // ID murid yang diperbarui
            'object_type' => 'App\Models\Ortu', // Tabel/model yang menjadi objek
            'time_stamp' => $time, // Tabel/model yang menjadi objek
        ]);

        $ortu->delete();
        return redirect()->route('ortus.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function show($id_ortu)
    {
        $ortu = Ortu::find($id_ortu);
        return view('ortus.detail', compact('ortu'));
    }


    // METHOD UNTUK MODUL

    public function dashboard()
    {
        $jam = JamPelajaran::orderBy('id_jam')->orderBy('jam_ke')->get()->groupBy('hari');
        // $id_kelas_user = Auth::user()->id_murid->murids->kelas->id_kelas;
        $id_murid = Auth::user()->id_murid;
        $murid = Murid::where('id_murid',$id_murid)->first();

        $prestasi_anak = PrestasiSiswa::where('id_murid',$id_murid)->count();
        $pelanggaran_anak = PelanggaranSiswa::where('id_murid',$id_murid)->count();
        // dd($id_kelas_user);

        $kelas = Kelas::where('id_kelas',$murid->id_kelas)->first();
        return view('modul.ortu.dashboard', compact
        ('kelas',
        'jam', 
        'prestasi_anak', 
        'pelanggaran_anak', 
        'murid'
        ));

    }
    public function modulpelanggaran ($id_murid)
    {
        $murid = Murid::with('kelas', 'ortus')->find($id_murid);
        $pelanggaranSiswa = PelanggaranSiswa::where('id_murid', $id_murid)
        ->with('pelanggaran')
        ->paginate(5);
        
        return view('modul.ortu.pelanggaran', compact(
            'murid',
            'pelanggaranSiswa',
        ));
    }
    public function modulprestasi ($id_murid)
    {
        $murid = Murid::with('kelas', 'ortus')->find($id_murid);
        $prestasiSiswa = PrestasiSiswa::where('id_murid', $id_murid)
        ->with('prestasi')
        ->paginate(5);
        
        return view('modul.ortu.prestasi', compact(
            'murid',
            'prestasiSiswa',
        ));
    }
    public function modulkehadiran($id_murid, KehadiranMuridChart $chart, GrafikLineChart $grafikLineChart)
    {
        $tahunAjaran = TahunAjaran::all();
        $murid = Murid::findOrFail($id_murid);
    
        // Build Donut chart for Kehadiran Murid
        $chart = (new KehadiranMuridChart)->build([
            'hadir' => 0,
            'izin' => 0,
            'mangkir' => 0
        ]);
    
        // GrafikLineChart will handle empty datasets
        $grafikLineChart = new GrafikLineChart();
    
        return view('modul.ortu.kehadiran', [
            'murid' => $murid,
            'chart' => $chart,
            'tahunAjaran' => $tahunAjaran,
            'grafikLineChart' => $grafikLineChart
        ]);
    }

    public function modulnilai($id_murid)
    {
        $murid = Murid::with('kelas')->where('id_murid', $id_murid)->first();
        if (!$murid) {
            return redirect()->route('rincians.index')->with('error', 'Murid tidak ditemukan.');
        }
      
    $tahunAjaran = Arsip::where('id_murid',$id_murid)->get('id_ta');
    $kode = TahunAjaran::whereIn('id_ta',$tahunAjaran)->get();

    if($kode->isEmpty()){
        return response()->json('Belum ada data Arsip');
    }

        return view( 'modul.ortu.nilai',[
            'murid' => $murid,
            'tahunAjaran' => $tahunAjaran,
            'kode' => $kode,
       
        ]);

    }
    

}
