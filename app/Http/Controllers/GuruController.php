<?php

namespace App\Http\Controllers;

use App\Models\PelanggaranSiswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Guru;
use App\Models\TahunAjaran;
use App\Models\JadwalPelajaran;
use App\Models\Mapel;
use App\Models\ActivityLog;
use App\Models\Kelas;
use App\Models\Arsip;
use App\Models\Roles;
use App\Models\Sesi;
use App\Models\Murid;
use App\Models\Nilai;
use App\Models\Ortu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class GuruController extends Controller
{

    public function index()
{
    // untuk ngatur gurus/index.blade.php
    $gurus = Guru::with('roles', 'mapels')->orderBy('nama_guru')->get(); // Me-load data roles dan mapels untuk setiap guru

    // return view('gurus.index', compact('gurus'));
    return view('gurus.index', ['gurus' => Guru::orderBy('nama_guru')->paginate(10)]);
}


    // Method untuk menampilkan form tambah guru
    public function create()
    {
        // untuk gurus/create.blade.php
        $mapels = Mapel::all();
        $roles= Roles::all();
        return view('gurus.create', compact('mapels','roles'));
    }

    public function search(Request $request)
    {
        $data = Guru::where('nama_guru','LIKE','%'.request('q').'%')->orderBy("nama_guru","asc")->get();
        return response()->json($data);
    }

    public function livesearch(Request $request)
    {
        // untuk livesearch di gurus/index.blade.php
        $query = $request->input('q');

        $gurus = Guru::with(['roles', 'mapels'])
            ->where('nama_guru', 'LIKE', "%$query%")
            ->orderBy('nama_guru')
            ->get();

        return response()->json(['gurus' => $gurus]);
    }

    // Method untuk menyimpan data guru yang baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Guru::$rules);
    
        if ($validator->fails()) {
            return redirect()->route('gurus.create')
                ->withErrors($validator)
                ->withInput();
        }
    
        $request->validate([
            'nip' => 'required',
            'nama_guru' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);
    
        // Cek apakah peran telah dipilih
        if (!$request->has('role')) {
            return redirect()->back()->withInput()->withErrors(['role' => 'Pilih setidaknya satu peran']);
        }
    
        // Buat data guru
        $guru = Guru::create([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'role' => $request->role,
            'password' => Hash::make($request->nip) // Enkripsi password berdasarkan NIP
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan data guru baru: ' . $request->nama_guru, // Deskripsi aktivitas
            'object_id' => $guru->id_guru, // ID murid yang ditambahkan
            'object_type' => 'App\Models\Guru', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
        
        // Redirect ke halaman yang ditentukan setelah menyimpan data
        return redirect()->route('gurus.index')->with(['success' => 'Data Berhasil Disimpan']);
    }
    
    public function edit($id_guru)
    {
        // untuk mengatur view gurus/edit.blade.php
        $guru = Guru::find($id_guru);
        $roles = Roles::all(); 
        if (!$guru) {
            return redirect()->route('gurus.index')
                ->with('error_message', 'Guru dengan id '.$id_guru.' tidak ditemukan');
        }
        return view('gurus.edit', [
            'guru' => $guru,
            'roles' => $roles, 
          
        ]);
    }
    
    public function getguru(Request $request)
    {
        // untuk dropdown nama guru bedasarkan mapel yang dipilih (coba cek halaman jadwal)
        $id_mapel = $request->id_mapel;
        $gurus = Guru::where('id_mapel', $id_mapel)->get();
        // Mengembalikan data guru dalam format JSON
        return response()->json($gurus);
    }
    public function update(Request $request, $id_guru)
    {
        $guru = Guru::findOrFail($id_guru);
    
        $request->validate([
            'nip' => 'required',
            'nama_guru' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);


        $nipExists = Guru::where('nip', $request->nip)
            ->where('id_guru', '!=', $id_guru) 
            ->exists();

        if ($nipExists) {
        return redirect()->back()->withInput()->with(['error' => 'NIP sudah terdaftar, mohon masukkan NIP yang berbeda.']);
        }
    
        // Cek apakah peran telah dipilih
        if (!$request->has('role')) {
            return redirect()->back()->withInput()->withErrors(['role' => 'Pilih setidaknya satu peran']);
        }
    
        $oldData = $guru->toArray();
        
        // Update data guru
        $guru->update([
            'nip' => $request->nip,
            'nama_guru' => $request->nama_guru,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->nip) // Enkripsi ulang password jika NIP berubah
        ]);
        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui data guru: ' . $oldData['nama_guru'], // Deskripsi aktivitas
            'object_id' => $id_guru, // ID murid yang diperbarui
            'object_type' => 'App\Models\Guru', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        return redirect()->route('gurus.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    
    public function destroy($id_guru): RedirectResponse
    {
        // Hapus data guru dari database
        $guru = Guru::findOrFail($id_guru);

        $oldData = $guru->toArray();
        $time = Carbon::now()->format('Y-m-d H:i:s');
         
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus data guru: ' . $oldData['nama_guru'], // Deskripsi aktivitas
            'object_id' => $id_guru, // ID murid yang diperbarui
            'object_type' => 'App\Models\Guru', // Tabel/model yang menjadi objek
            'time_stamp' => $time, // Tabel/model yang menjadi objek
        ]);

        $guru->delete();
        return redirect()->back();
    }

    // Method Modul --Start

    public function dashboard()
    {
        $tglskrng = Carbon::today()->format('d-m-y');
        $mapel = Mapel::with('gurus')->where('id_guru',Auth::user()->id_guru)->get();
        return view('modul.guru.dashboard', compact('tglskrng','mapel'));
    }
    public function moduljadwal($id_guru)
    {
        $tahunAjaran = TahunAjaran::all();
        $guru = Guru::find($id_guru);
        $jamskrng = Carbon::now('Asia/Jakarta')->format('H:i:s');
        return view('modul.guru.jadwal', compact(
            'guru',

            'jamskrng',
            'tahunAjaran',
        )
    );
    }


    public function moduldetailmurid($id_guru)
    {
        $guru = Guru::find($id_guru);
        $tahunAjaran = TahunAjaran::all();
        return view('modul.guru.detail-murid', compact('guru','tahunAjaran'));
    }
    public function moduldetail($id_kelas, $id_ta, $id_guru)
    {
        $kelas = Kelas::with('murids')
        ->where('id_kelas', $id_kelas)
        ->where('id_ta', $id_ta)
        ->first();

        $guru = Guru::find($id_guru);

        // Pastikan untuk memeriksa jika kelas ada
        if (!$kelas) {
        return redirect()->back()->with('error', 'Kelas tidak ditemukan.');
        }
        // Mengambil murid yang masih berada di kelas yang diinput berdasarkan arsip, 
        // agar murid yang sudah pindah ke tahun ajaran baru tidak ditampilkan di daftar kelas lama
        $arsip = Arsip::where('id_kelas', $kelas->id_kelas)
                ->where('id_ta', $id_ta) // Ini hanya untuk tahun ajaran yang dipilih
                ->with('murids')
                ->get()
                ->unique('id_murid'); 

        // Mengembalikan view dengan data kelas dan arsip murid (tanpa duplikat)
        return view('modul.guru.detail', compact('kelas', 'arsip', 'guru'));
    }
    public function muriddetail($id_guru,$id_murid,$id_ta,$id_kelas)
    {
 
        $guru = Guru::where('id_guru',$id_guru)->first();
        $kelas = Kelas::where('id_kelas',$id_kelas)->first();
        $ta = TahunAjaran::where('id_ta',$id_ta)->first();
        $murid = Murid::where('id_murid',$id_murid)->first();
        $ortu = Ortu::where('id_murid',$id_murid)->get();
        $pelanggaran = PelanggaranSiswa::where('id_murid',$id_murid)->get();

        // dd($pelanggaran);

        return view('modul.guru.rincian-murid', compact( 
            'kelas',
            'ta',
            'pelanggaran',
            'guru',
            'ortu',
            'murid'
        ));
    }
    public function modulkelassaya($id_guru)
    {
        $guru = Guru::find($id_guru);
        $tahunAjaran = TahunAjaran::all();
        return view('modul.guru.kelas-saya', compact('guru','tahunAjaran'));
    }
    public function moduldaftarmurid($id_kelas,$id_guru)
    {
        $guru = Guru::find($id_guru); 
        $kelas = Kelas::with('murids')->where('id_kelas',$id_kelas)->first();

        $arsip = Arsip::where('id_kelas', $kelas->id_kelas)
        ->with('murids')
        ->get()
        ->unique('id_murid'); 
        // dd($guru->id_guru);
        return view('modul.guru.daftar-murid', compact('kelas','guru','arsip'));
    }
    


    public function modulkelolanilai($id_murid, $id_kelas, $id_guru)
    {
        $guru = Guru::where('id_guru',$id_guru)->first();
        $kelas = Kelas::where('id_kelas', $id_kelas)->first();
        $murid = Murid::where('id_murid', $id_murid)->first();
        $arsip = Arsip::where('id_murid', $id_murid)->where('id_ta', $kelas->id_ta)->first();
        
        // Ambil data jadwal pelajaran beserta nilai
        $jadwal = JadwalPelajaran::with('mapels.nilais')
            ->where('id_ta', $arsip->id_ta)
            ->where('id_kelas', $arsip->id_kelas)
            ->get()
            ->unique('id_mapel');

        $tahunAjaran = TahunAjaran::where('id_ta',$kelas->id_ta)->first();
    
        $jadwalData = [];
        $totalNilai = 0;
        $jumlahNilai = 0;
    
        foreach ($jadwal as $data) {
            $nilai = $data->mapels->nilais
                ->where('id_murid', $id_murid)
                ->where('id_ta', $arsip->id_ta)
                ->first();
            
            $nilaiValue = $nilai ? $nilai->nilai : null;
            $idNilai = $nilai ? $nilai->id_nilai : null;

            if ($nilaiValue !== null) {
                $totalNilai += $nilaiValue;
                $jumlahNilai++;
            }
            
            $jadwalData[] = [
                'mapel' => $data->mapels,
                'nilai' => $nilaiValue,
                'id_nilai' => $idNilai,
            ];            
        }

        // Hitung rata-rata
        $rata = ($jumlahNilai > 0) ? ($totalNilai / $jumlahNilai) : 0;
    
        return view('modul.guru.kelola-nilai', compact(
            'jadwalData',
            'kelas',
            'murid',
            'totalNilai',
            'guru',
            'tahunAjaran',
            'rata'
        ));
    }
    public function modulkehadiran($id_ta ,$id_kelas, $id_guru)
    {
        $kelas = Kelas::where('id_kelas',$id_kelas)->first();
        $guru = Guru::findOrFail($id_guru);
        $tgl_sekarang = Carbon::now('Asia/Jakarta')->format('y-m-d');

        $sesi = Sesi::where('tanggal',$tgl_sekarang)->first();

        return view('modul.guru.kehadiran', compact('guru',
        'tgl_sekarang',
        'kelas',
        'sesi',
    ));
   
    }
    
 
    public function modulgetjadwal(Request $request)
    {
        $id_guru = $request->input('id_guru');
        $id_ta = $request->input('id_ta');
        $hari = $request->input('hari');

        $jadwal = JadwalPelajaran::with(['kelas.guru', 'jampels','mapels'])
            ->where('id_guru',$id_guru)
            ->where('id_ta',$id_ta)
            ->whereHas('jampels', function($q) use($hari){
                $q->where('hari',$hari);
            })
            ->get();

        $sort = $jadwal->sortby(function($q){
            return $q->jampels->jam_mulai;
        });

        return response()->json($sort->values());

    }

    public function modulgetkelas(Request $request)
    {
        $id_guru = $request->input('id_guru');
        $id_ta = $request->input('id_ta');

        $kelas = Kelas::with('tahunAjaran')
                ->where('id_guru',$id_guru)
                ->where('id_ta',$id_ta)
                ->get();

        if($kelas->isEmpty())
        {
            return response()->json(['message' => 'Tidak ada Kelas yang Di Ampu'], 200);
        }
        
    
        return response()->json($kelas);
    }



    public function modulnilai2($id_guru)
    {
        $guru = Guru::find($id_guru);
        $tahunAjaran = TahunAjaran::all();

        if (!$guru) {
            dd('Guru tidak ditemukan');
        }

        return view('modul.guru.tes-nilai', compact('guru','tahunAjaran'));
    }

    
    public function modulgetdata(Request $request)
    {

        $id_guru = $request->input('id_guru');
        $id_mapel = $request->input('id_mapel');
        $id_ta = $request->input('id_ta');
    
        
        $kelas_jadwal = JadwalPelajaran::where('id_guru', $id_guru)
            ->where('id_mapel', $id_mapel)
            ->where('id_ta', $id_ta)
            ->pluck('id_kelas');
    

        $murid_kelas = Kelas::with('murids') 
            ->whereIn('id_kelas', $kelas_jadwal)
            ->get();
    
        $murid = Murid::with('kelas')
                ->whereIn('id_kelas',$kelas_jadwal)
                ->orderBy('id_kelas')
                ->orderBy('nama_murid')
                ->get();

        $mapel = Mapel::where('id_mapel',$id_mapel)->first(); 

        // Ambil id_murid 
        $id_murid = $murid_kelas->flatMap(function ($kelas) {
            return $kelas->murids->pluck('id_murid');
        })->all();

        
    
        
        $nilai_murid = Nilai::where('id_mapel', $id_mapel)
            ->where('id_ta', $id_ta)
            ->whereIn('id_murid', $id_murid)
            ->get();
    
        // Kembalikan data yang diperlukan
        return response()->json([
            // 'kelas_jadwal' => $kelas_jadwal,
            // 'murid_kelas' => $murid_kelas,
            'nilai_murid' => $nilai_murid,
            'murid' => $murid,
            'mapel' => $mapel,
        ]);
    }
    

    // Method Modul --End
}
