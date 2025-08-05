<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PelanggaranSiswa;
use App\Models\Pelanggaran;
use App\Models\Murid;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PelanggaranSiswaController extends Controller
{

    public function index()
    {
        // untuk mengatur tampilan file pelanggaran_siswa/index.blade.php  
        // Mengambil dan mengurutkan pelanggaran siswa berdasarkan nama kelas dan nama murid
        $pelanggaranSiswa = PelanggaranSiswa::select('id_murid', \DB::raw('count(*) as pelanggaran_count'))
            ->groupBy('id_murid')
            ->with(['murid' => function ($query) {
                // $query->with('kelas')->orderby('id_kelas');
                $query->with(['kelas' => function($q){
                    $q->orderBy('nama_kelas');
                }]);
                }])
                // ->sortBy(function ($item) {
                    //     return $item->murid->kelas->nama_kelas . ' ' . $item->murid->nama_murid;
                    //     })
                    // 
                ->paginate(10);

        // Mengambil data pelanggaran dan murid
        $pelanggaran = Pelanggaran::orderBy("nama_pelanggaran", "asc")->get();
        $murids = Murid::all();
        return view('pelanggaran_siswa.index', [
            'pelanggaranSiswa' =>$pelanggaranSiswa, 
            'murids' =>$murids, 
            'pelanggaran'=>$pelanggaran
        ]);
    }


    public function send(Request $request)
    {
        // ini untuk simpan data dari halaman pelanggaran_siswa/index.blade.php kedalam database
        $pelanggaranSiswa = new PelanggaranSiswa();
        $pelanggaranSiswa->id_pelanggaran = $request->id_pelanggaran;
        $pelanggaranSiswa->id_murid = $request->id_murid;
        $pelanggaranSiswa->lokasi_pelanggaran = $request->lokasi_pelanggaran;
        $pelanggaranSiswa->tanggal_pelanggaran = $request->tanggal_pelanggaran;
        $pelanggaranSiswa->save();

        $nama_murid = $pelanggaranSiswa->murid->nama_murid;
        $nama_pelanggaran = $pelanggaranSiswa->pelanggaran->nama_pelanggaran;

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Data Murid Melanggar: ' . $nama_murid . ' ( ' .$nama_pelanggaran. ' )' , // Deskripsi aktivitas
            'object_id' => $pelanggaranSiswa->id, // ID murid yang ditambahkan
            'object_type' => 'App\Models\PelanggaranSiswa', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        return response()->json(['message' => 'Pelanggaran created successfully', 'data' => $pelanggaranSiswa], 201);
    }

public function getkelas(Request $request)
{
    // untuk  dropdown kelas onchange di pelanggaran_siswa/index.blade.php 
    // untuk  dropdown kelas onchange di pelanggaran_siswa/detail.blade.php 
    $id_murid = $request->id_nama;
    $murid = Murid::where('id_murid', $id_murid)->get('id_kelas');
    
    $nama_kelas = [];
    foreach ($murid as $murid_item) {
        $nama_kelas[] = Kelas::where('id_kelas', $murid_item->id_kelas)->value('nama_kelas');
    }
    
    return response()->json($nama_kelas);
}

public function gettahun(Request $request)
{
    // untuk  dropdown kelas onchange di pelanggaran_siswa/index.blade.php 
    // untuk  dropdown kelas onchange di pelanggaran_siswa/detail.blade.php 
    $id_murid = $request->id_nama;
    $ta = Murid::where('id_murid', $id_murid)->get('id_ta');
    
    $nama_ta = [];
    foreach ($ta as $item) {
        $nama_ta[] = TahunAjaran::where('id_ta', $item->id_ta)->value('kode_ta');
    }
    
    return response()->json($nama_ta);
}


public function detail($id_murid)
{
    // Untuk mengatur tampilan di pelanggaran_siswa/detail.blade.php
    // Mengambil murid berdasarkan id_murid
    $murid = Murid::with('kelas', 'ortus')->find($id_murid);

    // Mengambil pelanggaran siswa berdasarkan id_murid
    $pelanggaranSiswa = PelanggaranSiswa::where('id_murid', $id_murid)
                        ->with('pelanggaran')
                        ->paginate(5);

    return view('pelanggaran_siswa.detail', compact('murid', 'pelanggaranSiswa'));
}


public function update(Request $request, $id)
{
    $pelanggaranSiswa = PelanggaranSiswa::findOrFail($id);

    $request->validate([
        'id_pelanggaran' => 'required|exists:pelanggaran,id_pelanggaran'
    ]);

    // Ambil data lama termasuk nama murid dan nama pelanggaran
    $oldData = [
        'nama_murid' => $pelanggaranSiswa->murid->nama_murid,
        'nama_pelanggaran' => $pelanggaranSiswa->pelanggaran->nama_pelanggaran
    ];

    // Update data baru
    $pelanggaranSiswa->id_pelanggaran = $request->input('id_pelanggaran');
    $pelanggaranSiswa->lokasi_pelanggaran = $request->input('lokasi_pelanggaran');
    $pelanggaranSiswa->tanggal_pelanggaran = $request->input('tanggal_pelanggaran');
    $pelanggaranSiswa->save();

    $time = Carbon::now()->format('Y-m-d H:i:s');
    
    // Catat log aktivitas
    ActivityLog::create([
        'actor_id' => Auth::user()->id, // ID user administrator yang login
        'actor_type' => 'App\Models\User', // Tabel asal aktor
        'action' => 'update', // Aksi CRUD (update)
        'description' => 'Memperbarui Data Pelanggaran Murid: ' . $oldData['nama_murid'] . 
                         ', Pelanggaran Sebelumnya: ' . $oldData['nama_pelanggaran'], // Deskripsi aktivitas
        'object_id' => $id, // ID murid yang diperbarui
        'object_type' => 'App\Models\PelanggaranSiswa', // Tabel/model yang menjadi objek
        'time_stamp' => $time, 
    ]);

    return response()->json(['success' => 'Data pelanggaran siswa berhasil diperbarui.']);
}




public function destroy($id_pelanggaran)
{
    // Cari data pelanggaran siswa yang akan dihapus
    $pelanggaranSiswa = PelanggaranSiswa::findOrFail($id_pelanggaran);

    // Ambil data lama sebelum dihapus
    $oldData = [
        'nama_murid' => $pelanggaranSiswa->murid->nama_murid,
        'nama_pelanggaran' => $pelanggaranSiswa->pelanggaran->nama_pelanggaran
    ];

    // Hapus data
    $pelanggaranSiswa->delete();

    // Waktu log
    $time = Carbon::now()->format('Y-m-d H:i:s');

    // Catat log aktivitas
    ActivityLog::create([
        'actor_id' => Auth::user()->id, // ID user administrator yang login
        'actor_type' => 'App\Models\User', // Tabel asal aktor
        'action' => 'delete', // Aksi CRUD (delete)
        'description' => 'Menghapus Data Pelanggaran Murid: ' . $oldData['nama_murid'] . 
                         ', Pelanggaran: ' . $oldData['nama_pelanggaran'], // Deskripsi aktivitas
        'object_id' => $id_pelanggaran, // ID data yang dihapus
        'object_type' => 'App\Models\PelanggaranSiswa', // Tabel/model yang menjadi objek
        'time_stamp' => $time, 
    ]);

    return redirect()->back()->with('success', 'Data pelanggaran siswa berhasil dihapus.');
}




}
