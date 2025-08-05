<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PrestasiController extends Controller
{
    public function index()
    {
        // untuk mengatur halaman prestasi/index.blade.php
        $prestasi = Prestasi::orderBy('nama_prestasi')->paginate(10);
        return view('prestasi.index',['prestasi'=>$prestasi]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_prestasi' => 'required|string|max:255',
            'poin' => 'required|integer',
        ]);
        $prestasi = new Prestasi();
        $prestasi->nama_prestasi = $request->nama_prestasi;
        $prestasi->poin = $request->poin;
        $prestasi->save();

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Data Prestasi Baru: ' . $request->nama_prestasi, // Deskripsi aktivitas
            'object_id' => $prestasi->id_prestasi, // ID murid yang ditambahkan
            'object_type' => 'App\Models\Prestasi', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
        return response()->json(['message' => 'Prestasi created successfully', 'data' => $prestasi], 201);
    }
    public function search(Request $request)
    {
        $data = Prestasi::where('nama_prestasi','LIKE','%'.request('q').'%')->orderBy("nama_prestasi","asc")->get();
        return response()->json($data);
    }
    public function update(Request $request, $id_prestasi)
    {
        $prestasi = Prestasi::findOrFail($id_prestasi);
        $oldData = $prestasi->toArray();

        $prestasi->update($request->all());

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Data Prestasi: ' . $oldData['nama_prestasi'], // Deskripsi aktivitas
            'object_id' => $id_prestasi, // ID murid yang diperbarui
            'object_type' => 'App\Models\Prestasi', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
        return response()->json(['success' => true]);
    }
    public function destroy($id_prestasi)
    {
        $prestasi = Prestasi::findOrFail($id_prestasi);

        $oldData = $prestasi->toArray();

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus Data Prestasi: ' . $oldData['nama_prestasi'], // Deskripsi aktivitas
            'object_id' => $id_prestasi, // ID murid yang diperbarui
            'object_type' => 'App\Models\Prestasi', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
        $prestasi->delete();
        return redirect()->back()->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
