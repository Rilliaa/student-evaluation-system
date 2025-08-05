<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kehadiran;
use App\Models\Arsip;
use App\Models\TahunAjaran;
use App\Models\Murid;
use App\Models\Sesi;
use App\Models\Kelas;

use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;



class KehadiranController extends Controller
{
    // Method untuk menampilkan semua kehadiran
    public function index()
    {
        // mengatur tampilan kehadirans/index.blade.php
        // sebenar nya ini ga kepake lagi 
        $kehadirans = Kehadiran::all();
        return view('kehadirans.index', compact('kehadirans'));
    }

    // Method untuk menyimpan data kehadiran baru
    public function store(Request $request)
    {
       //method store dan delete udah ga guna lagi karna saat cek kehadiran jika tidak ada data maka akan otomatis hadir
        $request->validate([
            'id_murid_modal' => 'required',
            'id_kelas_modal' => 'required',
            'id_sesi_modal' => 'required',
            'status' => 'required',
  
        ]);

   
        $kehadiran = new Kehadiran();
        // dd("Data Kehadiran =",$kehadiran);
        $kehadiran->id_murid = $request->id_murid_modal;
        $kehadiran->id_kelas = $request->id_kelas_modal;
        $kehadiran->id_sesi = $request->id_sesi_modal;
        $kehadiran->status = $request->status;
        $kehadiran->keterangan = $request->keterangan;
        $kehadiran->save();

        return response()->json(['message' => 'Data kehadiran berhasil disimpan'], 200);
    }


    

    
public function rincian()
{
    // untuk mengatur tampilan kehadirans/rincian.blade.php
    $tahunAjaran = TahunAjaran::orderby('tahun_mulai','desc')->orderBy('kode_ta','desc')->get();
        $kelas = Kelas::orderBy('id_kelas')->paginate(10);

        return view('kehadirans.rincian', [
            'kelas'=>$kelas,
            'tahunAjaran' => $tahunAjaran,

        ]);
}

public function cekKehadiran(Request $request)
{
    // untuk bikin siswa langsung status hadir
    $id_sesi = $request->input('id_sesi');
    $id_kelas = $request->input('id_kelas');   

    $murids = Murid::where('id_kelas',$id_kelas)->get();

    $kehadiran = null; // Inisialisasi variabel di luar foreach

    foreach ($murids as $murid) {
        $kehadiran = Kehadiran::where('id_murid', $murid->id_murid)
            ->where('id_sesi', $id_sesi)
            ->first();
    
        if (!$kehadiran) {
            Kehadiran::create([
                'id_murid' => $murid->id_murid,
                'id_kelas' => $murid->id_kelas,
                'status' => 'Hadir',
                'keterangan' => null,
                'id_sesi' => $id_sesi
            ]);
        }
    }
    
    // Masuk ke bagian ini setelah foreach
    if (!$kehadiran) {
        $kelas = Kelas::where('id_kelas', $request->id_kelas)->first();
        $sesi = Sesi::where('id_sesi', $request->id_sesi)->first();
    
        $role = Auth::user()->roles->nama_roles;
        $userId = $role === "Admin" ? Auth::user()->id : Auth::user()->id_guru;
        $userModel = $role === "Admin" ? "User" : "Guru";
    
        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        ActivityLog::create([
            'actor_id' => $userId,
            'actor_type' => "App\Models\\{$userModel}",
            'action' => 'create',
            'description' => 'Menambahkan Data Kehadiran Untuk Kelas : ' . $kelas->nama_kelas . ' tanggal : ' . $sesi->tanggal,
            'object_id' => $id_kelas,
            'object_type' => 'App\Models\Kehadiran',
            'time_stamp' => $time,
        ]);
    }
    

    $kehadirans = Kehadiran::where('id_sesi',$id_sesi)
    ->whereIn('id_murid',$murids->pluck('id_murid'))
    ->get();



    return response()->json($kehadirans);
}



public function getKehadiranByMurid(Request $request)
{
    $id_kelas = $request->input('id_kelas');
    $id_sesi = $request->input('id_sesi');
  
    // ngambil id_murid dari arsip dengan parameter id_kelas
    $id_murid = Arsip::where('id_kelas', $id_kelas)->pluck('id_murid');
  

    $murids = Murid::with(['kehadirans' => function($q) use($id_sesi) {
            $q->where('id_sesi', $id_sesi);  
        }, 'kelas'])
        ->whereIn('id_murid', $id_murid) 
        ->orderBy('nama_murid')
        ->get();

  
        // dd($murids->id_kelas);

      
    return response()->json($murids);
}





    // Method untuk menyimpan perubahan data kehadiran yang diedit
    public function update(Request $request, $id_kehadiran)
    {

        $id = Kehadiran::findOrFail($id_kehadiran);
        $request->validate([
            'status' => 'required',
        ]);
        $oldData = $id->toArray();

        $id->update([
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        $murid = Murid::where('id_murid', $request->id_murid_edit)->first();

        // Ambil informasi aktor (Admin atau Guru)
        $role = Auth::user()->roles->nama_roles;
        $userId = $role === "Admin" ? Auth::user()->id : Auth::user()->id_guru;
        $userModel = $role === "Admin" ? "User" : "Guru";

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => $userId,
            'actor_type' => "App\Models\\{$userModel}",
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Data Kehadiran dari ' . $oldData['status'] . ' ke-' .$request->status . ' untuk murid ' .$murid->nama_murid, // Deskripsi aktivitas
            'object_id' => $id_kehadiran, // ID murid yang diperbarui
            'object_type' => 'App\Models\Kehadiran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        return redirect()->back()->with('success', 'Data kehadiran berhasil diperbarui.');
    }
    
    public function getIdMuridByName(Request $request)
    {   
        // lupa fungsi nya untuk apa 
        $namaMurid = $request->input('nama_murid');
        $murid = Murid::where('nama_murid', $namaMurid)->first();
         if($murid) {
         return response()->json(['id_murid' => $murid->id_murid]);
        } else {
         return response()->json(['id_murid adalah' => null]);
          }
    
      
    }

        public function destroy($id)
        {
            $kehadiran = Kehadiran::findOrFail($id);
            $kehadiran->delete();

            return redirect()->back()->with('success', 'Data kehadiran berhasil dihapus.');
        }

    
        public function kehadiranbysesi(Request $request)
        {
            $request->validate([
                'tanggal' => 'required|date',
                'id_murid' => 'required'
            ]);
        
            $tanggal = $request->input('tanggal');
            $id_murid = $request->input('id_murid');

            $sesi = Sesi::where('tanggal', $tanggal)->first();
        
            if (!$sesi) {
                return response()->json(['Error' => 'Tanggal Sesi tidak valid'], 404);
            }
    
            // Ambil id_sesi dari sesi yang valid
            $id_sesi = $sesi->id_sesi;
        
            // Cek kehadiran berdasarkan id_sesi dan id_murid
            $kehadiran = Kehadiran::where('id_sesi', $id_sesi)
                                  ->where('id_murid', $id_murid)
                                  ->first();
        
            // Jika kehadiran tidak ditemukan
            if (!$kehadiran) {
                return response()->json([
                    'status' => '<span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>',
                    'keterangan' => '<span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>'
                ]);
            }
        
            // Jika kehadiran ditemukan
            $statusLabel = match ($kehadiran->status) {
                'Hadir' => '<span class="label label-lg label-light-danger label-inline" style="color: #d8f3e7;background-color: #00b267; border-radius: 5px; padding: 3px 8px; text-align: center;">Hadir</span>',
                'Izin' => '<span class="label label-lg label-light-danger label-inline" style="color: #00246B;background-color: #CADCFC; border-radius: 5px; padding: 3px 8px; text-align: center;">Izin</span>',
                'Mangkir' => '<span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Mangkir</span>',
                default => '<span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>',
            };
        
            return response()->json([
                'status' => $statusLabel,
                'keterangan' => $kehadiran->keterangan ?? '<span class="label label-lg label-light-danger label-inline" style="color: #f64e60;background-color: #ffe2e5; border-radius: 5px; padding: 3px 8px; text-align: center;">Belum Ditentukan</span>'
            ]);
        }
        

   
   
}
