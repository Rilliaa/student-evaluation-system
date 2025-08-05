<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesi;
use App\Models\TahunAjaran;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;




class SesiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $tahunAjaran = TahunAjaran::orderby('tahun_mulai','desc')->orderBy('kode_ta','desc')->get();
        $sesi = Sesi::orderBy( 'tanggal', 'desc' )->paginate(5);
        // $sesi = Sesi::all();
        return view('sesi.index', compact('sesi', 'tahunAjaran'));
    }
    public function simpanSesiPembelajaran(Request $request)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'tanggal' => 'required|date',
            'hari' => 'required|string|max:255',
        ]);

        // Simpan data kehadiran ke dalam tabel kehadirans
        $sesi = Sesi::create([
            'tanggal' => $request->tanggal,
            'hari' => $request->hari,
            'id_ta' => $request->id_ta
            // Tambahkan kolom lain sesuai kebutuhan
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Sesi Baru: ' . $request->tanggal , // Deskripsi aktivitas
            'object_id' => $sesi->id_sesi, // ID murid yang ditambahkan
            'object_type' => 'App\Models\Sesi', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);


        // Response jika sukses (jika perlu)
        return response()->json(['message' => 'Data sesi pembelajaran berhasil disimpan'], 200);
    }
    public function filterByTanggal(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $sesi = Sesi::where('tanggal', $tanggal)->get();
        return response()->json($sesi);
    }
  
    


    public function cekTanggal(Request $request)
    {
        $tanggal = $request->tanggal;
        $exists = Sesi::where('tanggal', $tanggal)->exists();
        return response()->json(['exists' => $exists]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function getSesi(Request $request)
    {
        $sesi = Sesi::find($request->id_sesi);
        return response()->json($sesi);
    }
    
    public function update(Request $request,$id_sesi)
    {
        $sesi = Sesi::findOrFail($id_sesi);
        $request->validate([
            'tanggal' => 'required|date',
            'hari' => 'required|string'
            // 'id_ta' => 'required|integer',
        ]);
        $oldData = $sesi->toArray();
    
        $sesi->update([
            'tanggal' => $request->input('tanggal'),
            'hari' => $request->input('hari'),
            'id_ta' => $request->input('id_ta')
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');
        
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Data Sesi: ' . $oldData['tanggal'] , // Deskripsi aktivitas
            'object_id' => $id_sesi, // ID murid yang diperbarui
            'object_type' => 'App\Models\Sesi', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
        
        return response()->json(['success' => 'Sesi Berhasil Diperbarui']);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_sesi)
    {
        $sesi = Sesi::findOrFail($id_sesi);
        $oldData = $sesi->toArray();
        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus Data Sesi: ' . $oldData['tanggal'], // Deskripsi aktivitas
            'object_id' => $id_sesi, // ID murid yang diperbarui
            'object_type' => 'App\Models\Sesi', // Tabel/model yang menjadi objek
            'time_stamp' => $time, // Tabel/model yang menjadi objek
        ]);
        $sesi->delete();
        return redirect()->route('sesi.index')->with('success', 'Sesi berhasil dihapus.');
    }
    
}
