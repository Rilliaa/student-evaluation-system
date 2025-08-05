<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggaran = Pelanggaran::orderBy('poin','desc')->paginate(10);
        // $pelanggaran = Pelanggaran::orderBy('nama_pelanggaran','asc')->paginate(10);
        // $pelanggaran = Pelanggaran::all();
        return view('pelanggaran.index', ['pelanggaran'=> $pelanggaran]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'poin' => 'required|integer',
        ]);

        $pelanggaran = new Pelanggaran();
        $pelanggaran->nama_pelanggaran = $request->nama_pelanggaran;
        $pelanggaran->poin = $request->poin;
        $pelanggaran->save();

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Data Pelanggaran Baru: ' . $request->nama_pelanggaran, // Deskripsi aktivitas
            'object_id' => $pelanggaran->id_pelanggaran, // ID murid yang ditambahkan
            'object_type' => 'App\Models\Pelanggaran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        return response()->json(['message' => 'Pelanggaran created successfully', 'data' => $pelanggaran], 201);
    }

    public function search(Request $request)
    {
        $data = Pelanggaran::where('nama_pelanggaran','LIKE','%'.request('q').'%')->orderBy("nama_pelanggaran","asc")->get();
        return response()->json($data);
    }
    

    public function update(Request $request, $id_pelanggaran)
    {
        $pelanggaran = Pelanggaran::findOrFail($id_pelanggaran);
        $oldData = $pelanggaran->toArray();

        $pelanggaran->update($request->all());

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Data Pelanggaran: ' . $oldData['nama_pelanggaran'], // Deskripsi aktivitas
            'object_id' => $id_pelanggaran, // ID murid yang diperbarui
            'object_type' => 'App\Models\Pelanggaran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        return response()->json(['success' => true]);
    }
    

    public function destroy($id_pelanggaran)
    {
        $pelanggaran = Pelanggaran::findOrFail($id_pelanggaran);
        $oldData = $pelanggaran->toArray();

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus Data Pelanggaran: ' . $oldData['nama_pelanggaran'], // Deskripsi aktivitas
            'object_id' => $id_pelanggaran, // ID murid yang diperbarui
            'object_type' => 'App\Models\Pelanggaran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        $pelanggaran->delete();
        return redirect()->route('pelanggaran.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
