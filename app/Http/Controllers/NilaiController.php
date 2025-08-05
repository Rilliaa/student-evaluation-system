<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Murid;
use App\Models\Mapel;
use App\Models\ActivityLog;
use App\Models\TahunAjaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    // Method untuk menampilkan semua data nilai
    public function index()
    {
        $nilais = Nilai::with('murids','mapels')->paginate(10);
        return view('nilais.rekap', compact('nilais'));
    }

    // Method untuk menampilkan form tambah nilai
    public function create()
    {
        $murids = Murid::all();
    
        $mapel = Mapel::all();
        return view('nilais.create',['murids' => $murids],['mapels' => $mapel]);
    }

    // Method untuk menyimpan data nilai yang baru
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'id_murid' => 'required',
            'id_mapel' => 'required',
            'nilai' => 'required',
            'id_ta' => 'required'
        ]);
    
        // Simpan data nilai baru
        $nilai = Nilai::create($validatedData);
    
        // Ambil data tambahan
        $tahunAjaran = TahunAjaran::find($request->id_ta);
        $data = [
            'nama_murid' => $nilai->murids->nama_murid,
            'nama_mapel' => $nilai->mapels->nama_mapel,
            'kode_ta' => $tahunAjaran->kode_ta ?? 'Tidak Diketahui', // Jika tidak ditemukan
        ];
    
        // Ambil informasi aktor
        $role = Auth::user()->roles->nama_roles;
        $userId = $role === "Admin" ? Auth::user()->id : Auth::user()->id_guru;
        $userModel = $role === "Admin" ? "User" : "Guru";
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => $userId,
            'actor_type' => "App\Models\\{$userModel}",
            'action' => 'create',
            'description' => "Menambahkan Nilai Baru ({$nilai->nilai}) ke: {$data['nama_murid']}, Mapel: {$data['nama_mapel']}, Kode TA: {$data['kode_ta']}",
            'object_id' => $nilai->id_nilai,
            'object_type' => 'App\Models\Nilai',
            'time_stamp' => now()->format('Y-m-d H:i:s'),
        ]);
    
        return redirect()->back()->with('success', 'Data Berhasil Disimpan');
    }
    
    public function edit($id_nilai)
    {
        $nilai = Nilai::find($id_nilai);
        $murids = Murid::get(); // Mengambil semua data murid
        $mapels = Mapel::get(); // Mengambil semua data mapel
    
        if (!$nilai) {
            return redirect()->route('nilais.index')
                ->with('error_message', 'Nilai dengan id '.$id_nilai.' tidak ditemukan');
        }
    
        return view('nilais.edit', [
            'nilai' => $nilai,
            'murids' => $murids,
            'mapels' => $mapels
        ]);
    }
    

    // Method untuk menyimpan perubahan data nilai yang diedit
    public function update(Request $request, $id_nilai)
    {
        // Validasi data
        $validatedData = $request->validate([
            'id_murid' => 'required',
            'id_mapel' => 'required',
            'nilai' => 'required',
            'id_ta' => 'required'
        ]);
    
        // Ambil data lama sebelum diubah
        $nilai = Nilai::findOrFail($id_nilai);
        $tahunAjaran = TahunAjaran::where('id_ta',$request->id_ta)->first();

        $oldData = [
            'nama_murid' => $nilai->murids->nama_murid,
            'nama_mapel' => $nilai->mapels->nama_mapel,
            'kode_ta' => $tahunAjaran->kode_ta ?? 'Tidak Diketahui',
            'nilai' => $nilai->nilai,
        ];
    
        // Update data
        $nilai->update($validatedData);
    
        // Ambil data baru
        $newData = [
            'nama_murid' => $nilai->murids->nama_murid,
            'nama_mapel' => $nilai->mapels->nama_mapel,
            'kode_ta' => $tahunAjaran->kode_ta ?? 'Tidak Diketahui',
            'nilai' => $nilai->nilai,
        ];
    
        // Ambil informasi aktor
        $role = Auth::user()->roles->nama_roles;
        $userId = $role === "Admin" ? Auth::user()->id : Auth::user()->id_guru;
        $userModel = $role === "Admin" ? "User" : "Guru";
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => $userId,
            'actor_type' => "App\Models\\{$userModel}",
            'action' => 'update',
            'description' => "Memperbarui Nilai: Dari {$oldData['nilai']} ke {$newData['nilai']} untuk Murid: {$newData['nama_murid']}, Mapel: {$newData['nama_mapel']}, Kode TA: {$newData['kode_ta']}",
            'object_id' => $nilai->id_nilai,
            'object_type' => 'App\Models\Nilai',
            'time_stamp' => now()->format('Y-m-d H:i:s'),
        ]);
    
        return redirect()->back()->with('success', 'Data Berhasil Diubah!');
    }
    

  
    public function destroy($id_nilai)
    {
        // Ambil data yang akan dihapus
        $nilai = Nilai::findOrFail($id_nilai);

        $id_ta = Nilai::where('id_nilai',$id_nilai)->pluck('id_ta');
        $tahunAjaran = TahunAjaran::where('id_ta',$id_ta)->first();
    
        // Simpan informasi sebelum dihapus untuk lo
        $deletedData = [
            'nama_murid' => $nilai->murids->nama_murid,
            'nama_mapel' => $nilai->mapels->nama_mapel,
            'kode_ta' => $tahunAjaran->kode_ta ?? 'Tidak Diketahui',
            'nilai' => $nilai->nilai,
        ];
    
        // Ambil informasi aktor (Admin atau Guru)
        $role = Auth::user()->roles->nama_roles;
        $userId = $role === "Admin" ? Auth::user()->id : Auth::user()->id_guru;
        $userModel = $role === "Admin" ? "User" : "Guru";
    
        // Hapus data nilai
        $nilai->delete();
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => $userId,
            'actor_type' => "App\Models\\{$userModel}",
            'action' => 'delete',
            'description' => "Menghapus Nilai: {$deletedData['nilai']} untuk Murid: {$deletedData['nama_murid']}, Mapel: {$deletedData['nama_mapel']}, Kode TA: {$deletedData['kode_ta']}",
            'object_id' => $id_nilai,
            'object_type' => 'App\Models\Nilai',
            'time_stamp' => now()->format('Y-m-d H:i:s'),
        ]);
    
        // Redirect dengan pesan sukses
        return redirect()->back()->with('success_message', 'Nilai berhasil dihapus.');
    }
    

}
