<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrestasiSiswa;

use App\Models\Prestasi;
use App\Models\Murid;
use App\Models\Kelas;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PrestasiSiswaController extends Controller
{
    public function index()
    {
        // Mengatur tampilan file prestasi_siswa/index.blade.php
        // Mengambil dan mengurutkan prestasi siswa berdasarkan nama kelas dan nama murid
        $prestasiSiswa = PrestasiSiswa::select('id_murid', \DB::raw('count(*) as prestasi_count'))
        ->groupBy('id_murid')
        ->with(['murid' => function ($query) {
            // $query->with('kelas')->orderBy('id_kelas')->orderBy('nama_murid');

            $query->orderby('nama_murid')->with(['kelas' =>function($q){
                $q->orderBy('id_kelas');
            }]);
        }])
        ->paginate(10);

        // Mengambil data prestasi dan murid
        $prestasi = Prestasi::orderBy("nama_prestasi", "asc")->get();
        $murids = Murid::all();
        return view('prestasi_siswa.index', 
        [
            'prestasiSiswa' => $prestasiSiswa,
            'murids' => $murids,
            'prestasi' => $prestasi
        ]);
    }

    public function send(Request $request)
    {
        // Simpan data dari halaman prestasi_siswa/index.blade.php ke dalam database
        $prestasiSiswa = new PrestasiSiswa();
        $prestasiSiswa->id_prestasi = $request->id_prestasi;
        $prestasiSiswa->id_murid = $request->id_murid;
        $prestasiSiswa->lokasi_prestasi = $request->lokasi_prestasi;
        $prestasiSiswa->tanggal_prestasi = $request->tanggal_prestasi;
        $prestasiSiswa->save();

        $nama_murid = $prestasiSiswa->murid->nama_murid;
        $nama_prestasi = $prestasiSiswa->prestasi->nama_prestasi;

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Data Murid Berprestasi: ' . $nama_murid . ' ( ' .$nama_prestasi. ' )' , // Deskripsi aktivitas
            'object_id' => $prestasiSiswa->id, // ID murid yang ditambahkan
            'object_type' => 'App\Models\PrestasiSiswa', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        return response()->json(['message' => 'Prestasi created successfully', 'data' => $prestasiSiswa], 201);
    }

    public function getkelas(Request $request)
    {
        // Untuk dropdown kelas onchange di prestasi_siswa/index.blade.php 
        // dan prestasi_siswa/detail.blade.php
        $id_murid = $request->id_nama;
        $murid = Murid::where('id_murid', $id_murid)->get('id_kelas');
        
        $nama_kelas = [];
        foreach ($murid as $murid_item) {
            $nama_kelas[] = Kelas::where('id_kelas', $murid_item->id_kelas)->value('nama_kelas');
        }
        
        return response()->json($nama_kelas);
    }

    public function detail($id_murid)
    {
        // Untuk mengatur tampilan di prestasi_siswa/detail.blade.php
        // Mengambil murid berdasarkan id_murid
        $murid = Murid::with('kelas', 'ortus')->find($id_murid);

        // Mengambil prestasi siswa berdasarkan id_murid
        $prestasiSiswa = PrestasiSiswa::where('id_murid', $id_murid)
                            ->with('prestasi')
                            ->paginate(5);

        return view('prestasi_siswa.detail', compact('murid', 'prestasiSiswa'));
    }

    public function update(Request $request, $id)
    {
        $prestasiSiswa = PrestasiSiswa::findOrFail($id);
        $request->validate([
            'id_prestasi' => 'required|exists:prestasi,id_prestasi'
        ]);

        $oldData = [
            'nama_murid' => $prestasiSiswa->murid->nama_murid,
            'nama_prestasi' => $prestasiSiswa->prestasi->nama_prestasi
        ];

        $prestasiSiswa->id_prestasi = $request->input('id_prestasi');
        $prestasiSiswa->tanggal_prestasi = $request->input('tanggal_prestasi');
        $prestasiSiswa->lokasi_prestasi = $request->input('lokasi_prestasi');
        $prestasiSiswa->save();

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Data Murid Berprestasi: ' . $oldData['nama_murid'] . 
                             ', Prestasi Sebelumnya: ' . $oldData['nama_prestasi'], // Deskripsi aktivitas
            'object_id' => $id, // ID murid yang diperbarui
            'object_type' => 'App\Models\PrestasiSiswa', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        return response()->json(['success' => 'Data prestasi siswa berhasil diperbarui.']);
    }

    public function destroy($id_prestasi)
    {
        $prestasiSiswa = PrestasiSiswa::find($id_prestasi);

        $oldData = [
            'nama_murid' => $prestasiSiswa->murid->nama_murid,
            'nama_prestasi' => $prestasiSiswa->prestasi->nama_prestasi
        ];

        $prestasiSiswa->delete();

        $time = Carbon::now()->format('Y-m-d H:i:s');

        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (delete)
            'description' => 'Menghapus Data Murid Berprestasi: ' . $oldData['nama_murid'] . 
                             ', Prestasi: ' . $oldData['nama_prestasi'], // Deskripsi aktivitas
            'object_id' => $id_prestasi, // ID data yang dihapus
            'object_type' => 'App\Models\PrestasiSiswa', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        return redirect()->back()->with('success', 'Data prestasi siswa berhasil dihapus.');
    }
}
