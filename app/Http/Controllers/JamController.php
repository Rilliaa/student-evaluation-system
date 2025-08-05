<?php

namespace App\Http\Controllers;
use App\Models\JamPelajaran;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JamController extends Controller
{
    public function index()
    {
        // untuk mengatur tampilan jam.index.blade.pp
        $jamPelajarans = JamPelajaran::orderBy('id_jam')->orderBy('jam_ke')->get()->groupBy('hari');
        return view('jam.index', compact('jamPelajarans'));
    }
    
     public function fetch()
    {
        // lupa fungsi nya untuk apa 
        $jamPelajarans = JamPelajaran::orderBy('hari','desc')->orderBy('jam_ke')->get();
        return response()->json($jamPelajarans);
    }
    
    
    
    
    public function create()
    {
        // return view untuk jam/create.blade.php
        return view('jam.create');
    }

    // Method untuk menyimpan data role yang baru
    public function store(Request $request)
    {
        // store data ke database
        $request->validate([
            'jam_ke' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'hari' => 'required'
          
        ]);
        
        $jamPelajaran = JamPelajaran::create([
            'jam_ke' => $request->jam_ke,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
            'hari' => $request->hari
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Data Jam Baru: ' .'( ' .$request->hari. ' jam ke -'.$request->jam_ke. ' )' , // Deskripsi aktivitas
            'object_id' => $jamPelajaran->id_jam, // ID murid yang ditambahkan
            'object_type' => 'App\Models\JamPelajaran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        return redirect()->route('jam.index')->with('success_message', 'Jam Pelajaran berhasil ditambahkan');
    }
    


//     public function edit($id_jam)
// {
//     $jam = JamPelajaran::find($id_jam);
//     if (!$jam) {
//         return redirect()->route('jam.index')->with('error_message', 'Jam Pelajaran tidak ditemukan');
//     }
//     return view('jam.edit', compact('jam'));
// }




    public function update(Request $request, $id_jam)
    {
        $jamPelajaran = JamPelajaran::findOrFail($id_jam);
        
        // Validasi request
        $request->validate([
            'jam_ke_edit' => 'required',
            'jam_mulai_edit' => 'required',
            'jam_selesai_edit' => 'required'
            // 'hari_edit' => 'required',
            // 'keterangan_edit' => 'required',
        ]);

        $oldData = $jamPelajaran->toArray();
    
        // Update data jam dengan nilai baru dari request
        $jamPelajaran->update([
            'jam_ke' => $request->jam_ke_edit,
            'jam_mulai' => $request->jam_mulai_edit,
            'jam_selesai' => $request->jam_selesai_edit,
            'hari_modal_edit' => $request->hari,
            'keterangan' => $request->keterangan_edit
        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Data Jam: ' .'( ' .$oldData['hari']. ' jam ke -'.$oldData['jam_ke']. ' )', // Deskripsi aktivitas
            'object_id' => $id_jam, // ID murid yang diperbarui
            'object_type' => 'App\Models\JamPelajaran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        // Redirect atau kirim respons sebagai balasan
        return redirect()->route('jam.index')->with('success', 'Jam berhasil diperbarui.');
    }



    public function destroy(Request $request, $id_jam)
    {
        $jam = JamPelajaran::findOrFail($id_jam);

        $oldData = $jam->toArray();

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus Data Jam : ' . '( ' . $oldData['hari'] . ' jam ke-'.$oldData['jam_ke']. ')' , // Deskripsi aktivitas
            'object_id' => $id_jam, // ID murid yang diperbarui
            'object_type' => 'App\Models\JamPelajaran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        $jam->delete();
        return redirect()->route('jam.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
//     public function getIdJamByJamKe(Request $request)
// {
//     $jamKe = $request->input('jam_ke');
    
//     // Cari id_jam berdasarkan jam_ke
//     $jam = JamPelajaran::where('jam_ke', $jamKe)->first();
    
//     // Jika id_jam ditemukan, kirim sebagai respons JSON
//     if ($jam) {
//         return response()->json(['id_jam' => $jam->id_jam]);
//     } else {
//         // Jika tidak ditemukan, kirim respons kosong atau sesuai dengan kebutuhan Anda
//         return response()->json(['id_jam Tidak Ditemukan :' => null]);
//     }
// }

    
}
