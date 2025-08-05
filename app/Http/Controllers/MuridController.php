<?php


namespace App\Http\Controllers;

use App\Charts\GrafikLineChart;
use App\Charts\KehadiranMuridChart;
use App\Models\PelanggaranSiswa;
use App\Models\PrestasiSiswa;
use Illuminate\Http\Request;
use App\Models\Murid;
use App\Models\Kelas;
use App\Models\Roles;
use App\Models\TahunAjaran;
use App\Models\Sesi;
use App\Models\Arsip;
use App\Models\JadwalPelajaran;
use App\Models\Kehadiran;
use App\Models\JamPelajaran;
use App\Models\ActivityLog; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class MuridController extends Controller
{
    // Method untuk menampilkan semua murid

    public function index()
    {
      
        $tahunAjaran = TahunAjaran::orderBy('tahun_mulai', 'desc')->orderBy('kode_ta', 'desc')->get();
        return view('murids.index', [
            'tahunAjaran' => $tahunAjaran,
            'murids' => Murid::orderby('id_kelas')->orderBy('nama_murid')->paginate(10)
        ]);
    }
    
    public function getByTahunAjaran(Request $request)
    {
        // untuk menampilkan data murid bedasarkan tahun ajaran pada murids/index-beta
        $id_ta = $request->input('id_ta');
        $murids = Murid::where('id_ta', $id_ta)
            ->with(['kelas', 'tahunAjaran', 'roles'])
            ->orderBy('nama_murid')
            ->paginate(10)
            ->unique('nisn');
        return response()->json($murids);
    }
    
    public function detail($id_murid, $id_ta, $id_kelas)
    {
        $kelas = Kelas::where('id_kelas', $id_kelas)->first();
        $murid = Murid::where('id_murid', $id_murid)->first();
        $arsip = Arsip::where('id_murid', $id_murid)->where('id_ta', $kelas->id_ta)->first();
        
        // dd($kelas->id_kelas);
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
        $rata= number_format($rata,2);
    // return view('murids.detail', compact('murid', 'jadwal', 'totalNilai', 'rata'));
    return view('murids.detail', compact(
        'jadwalData',
            'kelas',
            'murid',
            'totalNilai',
            'tahunAjaran',
            'rata'
    ));
    }
    
    
    
    public function search(Request $request)
    {
        $data = Murid::where('nama_murid','LIKE','%'.request('q').'%')->orderBy("nama_murid","asc")->get();
        return response()->json($data);
    }
    public function livesearch(Request $request)
    {
        $query = $request->input('q');
    
        $murids = Murid::with(['kelas', 'tahunAjaran', 'roles'])
            ->where('nama_murid', 'LIKE', "%$query%")
            ->orderBy('id_kelas')
            ->orderBy('nama_murid')
            ->get();
    
        // Log::debug($murids);
    
        return response()->json(['murids' => $murids]);
    }

    public function create()
    {
        $murid = Murid::all();
        $roles= Roles::all();
        $kelas= Kelas::all();
        $tahunAjaran = TahunAjaran::orderby('tahun_mulai','desc')->orderBy('kode_ta','desc')->get();
        // return view('murids.create', compact('kelas', 'roles','tahunAjaran','murid'));
        return view('murids.create', [
            'murid' => $murid,
            'roles' => $roles,
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas // Melewatkan data kelas ke view
        ]);
    }
    public function edit($id_murid)
    {
        $murid = Murid::find($id_murid);
        $roles = Roles::all(); 
        $kelas = Kelas::all();
        $tahunAjaran = TahunAjaran::orderby('tahun_mulai','desc')->orderBy('kode_ta','desc')->get();
        if (!$murid) {
            return redirect()->route('murids.index')
                ->with('error_message', 'Murid dengan id '.$id_murid.' tidak ditemukan');
        }
        return view('murids.edit', [
            'murid' => $murid,
            'roles' => $roles,
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas // Melewatkan data kelas ke view
        ]);
    }
    public function getKelas(Request $request)
    {
        // untuk select2 di  proses transisi
        $id_ta = $request->input('id_ta');
        $kelas = Kelas::where('id_ta',$id_ta)->get();
        
        if($kelas->isEmpty()) {
            return response("<option value=''>Tidak ada kelas untuk tahun ajaran ini</option>");
        }

        $options = "<option value=''>Pilih Kelas</option>";
        foreach ($kelas as $kls) {
            $options .= "<option value='{$kls->id_kelas}'>{$kls->nama_kelas}</option>";
        }
    
        return response($options);
    }
    
    
    // Method untuk menyimpan data murid yang baru
    public function store(Request $request)
    {
 
        $request->validate([
            'nisn' => 'required',
            'nama_murid' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'id_kelas' => 'required',
            'id_ta' => 'required',
            'role' => 'required'
        ]);

        $existingMurid = Murid::where('nisn', $request->nisn)->first();
        if ($existingMurid) {
            return redirect()->back()->withErrors(['nisn' => 'NISN sudah terdaftar.'])->withInput();
        }
    

        $murid = Murid::create([
            'nisn' => $request->nisn,
            'nama_murid' => $request->nama_murid,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'id_kelas' => $request->id_kelas,
            'role' => $request->role,
            'id_ta' => $request->id_ta,
            'password' => Hash::make($request->nisn)
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan data murid baru: ' . $request->nama_murid, // Deskripsi aktivitas
            'object_id' => $murid->id_murid, // ID murid yang ditambahkan
            'object_type' => 'App\Models\Murid', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
        
        // Redirect ke halaman yang ditentukan setelah menyimpan data
        return redirect()->route('murids.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    public function update(Request $request, $id_murid)
    {
        // Ambil data murid berdasarkan ID
        $murid = Murid::findOrFail($id_murid);
    
        // Validasi input
        $request->validate([
            'nisn' => 'required',
            'nama_murid' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'id_kelas' => 'required',
            'id_ta' => 'required',
            'role' => 'required'
        ]);
    
        // Cek apakah NISN sudah digunakan oleh murid lain
        $nisnExists = Murid::where('nisn', $request->nisn)
            ->where('id_murid', '!=', $id_murid)
            ->exists();
    
        if ($nisnExists) {
            return redirect()->back()->withInput()->with(['error' => 'NISN sudah terdaftar, mohon masukkan NISN yang berbeda.']);
        }
    
        // Simpan data lama sebelum update
        $oldData = $murid->toArray();
    
        // Update data murid
        $murid->update([
            'nisn' => $request->nisn,
            'nama_murid' => $request->nama_murid,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'id_kelas' => $request->id_kelas,
            'id_ta' => $request->id_ta,
            'role' => $request->role,
            'password' => Hash::make($request->nisn)
        ]);
        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui data murid: ' . $oldData['nama_murid'], // Deskripsi aktivitas
            'object_id' => $id_murid, // ID murid yang diperbarui
            'object_type' => 'App\Models\Murid', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('murids.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    

    public function destroy($id_murid): RedirectResponse
    {
        
        $murid = Murid::findOrFail($id_murid);
     
        $oldData = $murid->toArray();
        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus data murid: ' . $oldData['nama_murid'], // Deskripsi aktivitas
            'object_id' => $id_murid, // ID murid yang diperbarui
            'object_type' => 'App\Models\Murid', // Tabel/model yang menjadi objek
            'time_stamp' => $time, // Tabel/model yang menjadi objek
        ]);

        $murid->delete();
        return redirect()->route('murids.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function grafikshow($id_murid, KehadiranMuridChart $chart)
    {
        $tajaran = Arsip::where('id_murid',$id_murid)->get('id_ta');
        $kode = TahunAjaran::whereIn('id_ta',$tajaran)->get();

        $tahunAjaran = TahunAjaran::all();
        $murid = Murid::findOrFail($id_murid);
    
        // Inisialisasi chart dengan data default
        $chart = (new KehadiranMuridChart)->build([
            'hadir' => 0,
            'izin' => 0,
            'mangkir' => 0
        ]);
    
        return view('murids.grafik', [
            'murid' => $murid,
            'kode' => $kode,
            'chart' => $chart,
            'tahunAjaran' => $tahunAjaran,
        ]);
    }
    

    public function grafikkehadiran($id_ta, $id_murid)
    {

        $sesi = Sesi::where('id_ta', $id_ta)->pluck('id_sesi'); 

        $total = Kehadiran::whereIn('id_sesi', $sesi)
        ->where('id_murid', $id_murid)
        ->count();

        $kehadiran = Kehadiran::whereIn('id_sesi', $sesi)
                    ->where('id_murid', $id_murid)
                    ->selectRaw("
                        SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as jumlah_hadir,
                        SUM(CASE WHEN status = 'Izin' THEN 1 ELSE 0 END) as jumlah_izin,
                        SUM(CASE WHEN status = 'Mangkir' THEN 1 ELSE 0 END) as jumlah_mangkir
                    ")
                    ->first();
    
        return response()->json([
            'sesi' => $sesi,
            'kehadiran' => $kehadiran,
            'total' => $total
     
        ]);
    }
    public function grafikline(Request $request, $id_murid)
    {
        $taAwal = $request->taAwal;
        $taAkhir = $request->taAkhir;
    

        //untuk mengambil seluruh id_sesi diantara id_Ta awal dan akhir
       $sesi = Sesi::whereBetween('id_ta', [$taAwal,$taAkhir])->pluck('id_sesi');
       
        
    // mengabil seluruh data "Hadir" di tabel kehadiran diantara ta awal dan akhir
       $kehadiranData = Kehadiran::where('id_murid',$id_murid)
                        ->whereIn('id_sesi',$sesi)
                        ->where('status','Hadir')
                        ->groupBy('id_sesi')
                        ->selectRaw('id_sesi, COUNT(*) as total_hadir, COUNT(*) as total_sesi')
                        ->get();
        

        // membuat persenase bedasarkan data kehadiran  dan mereturn value berupa kode_ta dan persentase hadir 
        $persentaseKehadiran = $kehadiranData->groupBy(function($data) {
            return Sesi::find($data->id_sesi)->id_ta;
        })->map(function($data, $id_ta) {
            $totalSesi = Sesi::where('id_ta', $id_ta)->count(); 
            $totalHadir = $data->sum('total_hadir'); 
    
            return [
                'kode_ta' => TahunAjaran::orderby('id_ta')->find($id_ta)->kode_ta,
                'persentase_hadir' => ($totalSesi > 0) ? ($totalHadir / $totalSesi) * 100 : 0 
            ];
        })->sortby('kode_ta')->values(); 


        
        // return response()->json($persentaseKehadiran);
        return response($persentaseKehadiran);
    }

    public function grafikNilai(Request $request, $id_murid) {
        $taAwal = $request->input('taAwal');
        $taAkhir = $request->input('taAkhir');
    
        $arsips = Arsip::where('id_murid', $id_murid)
            ->whereBetween('id_ta', [$taAwal, $taAkhir])
            ->with('kelas.tahunAjaran')
            ->get();
    
        $result = [];
    
        foreach ($arsips as $arsip) {
            $id_kelas = $arsip->id_kelas; 
            $id_ta = $arsip->id_ta; 
    
            $jadwal = JadwalPelajaran::with('mapels.nilais')
                ->where('id_kelas', $id_kelas)
                ->where('id_ta', $id_ta)
                ->get()
                ->unique('id_mapel');
    
            $totalNilai = 0;
            $jumlahMapel = 0;
    
            foreach ($jadwal as $data) {
                foreach ($data->mapels->nilais->where('id_murid', $id_murid)->where('id_ta',$id_ta) as $nilai) {
                    if ($nilai->id_murid == $id_murid ) { 
                        $totalNilai += $nilai->nilai;
                        $jumlahMapel++;
                    }
                }
            }
    
            $rataRataNilai = $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
            
            $rataRataNilai = number_format($rataRataNilai,2);
            // dd($rataRataNilai, $totalNilai, $jumlahMapel);
    
            $result[] = [
                'kode_ta' => $arsip->kelas->tahunAjaran->kode_ta,
                'rata_nilai' => $rataRataNilai
            ];
        }
    
        $result = collect($result)
            ->unique('kode_ta')
            ->sortBy('kode_ta')
            ->values()
            ->all();
    
        return response()->json($result);
    }
    
 

    // Method untuk Modul --Start 
    public function dashboard()
    {
        $jam = JamPelajaran::orderBy('id_jam')->orderBy('jam_ke')->get()->groupBy('hari');
        $id_kelas_user = Auth::user()->id_kelas;

        $kelas = Kelas::where('id_kelas',$id_kelas_user)->first();
        return view('modul.murid.dashboard', compact('jam','kelas'));
    }
    public function modulpelanggaran ($id_murid)
    {
        $murid = Murid::with('kelas', 'ortus')->find($id_murid);
        $pelanggaranSiswa = PelanggaranSiswa::where('id_murid', $id_murid)
        ->with('pelanggaran')
        ->paginate(5);
        
        return view('modul.murid.pelanggaran', compact(
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
        
        return view('modul.murid.prestasi', compact(
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
    
        return view('modul.murid.kehadiran', [
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

        return view( 'modul.murid.nilai',[
            'murid' => $murid,
            'tahunAjaran' => $tahunAjaran,
            'kode' => $kode,
       
        ]);

    }
    public function modulgetnilai($id_ta, $id_murid)
    {
        $arsip = Arsip::where('id_murid', $id_murid)->where('id_ta', $id_ta)->first();
        
        if(!$arsip) {
            return response()->json(['jadwal' => [], 'message' => 'Data arsip tidak ditemukan.']);
        }
    
        $jadwal = JadwalPelajaran::with('mapels.nilais')
            ->where('id_ta', $id_ta)
            ->where('id_kelas', $arsip->id_kelas)
            ->get()
            ->unique('id_mapel');
    
        $jadwalData = [];
        foreach ($jadwal as $data) {
            $nilai = $data->mapels->nilais
                ->where('id_murid', $id_murid)
                ->where('id_ta', $id_ta)
                ->first();
                
                $jadwalData[] = [
                    'mapel' => $data->mapels,
                    'nilai' => $nilai ? $nilai->nilai : null,
                ];
            }
            
            // dd("data",$jadwalData);
        return response()->json(['jadwal' => $jadwalData]);
    }

    public function moduljadwal($id_murid)
    {
        $tahunAjaran = TahunAjaran::all();
        $murid = Murid::find($id_murid);
        return view('modul.murid.jadwal',compact(
            'murid',
            'tahunAjaran'
    
    ));
    }
    
    


    // Method untuk Modul --End 
        
}
