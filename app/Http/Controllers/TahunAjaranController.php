<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Murid;
use App\Models\Arsip;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TahunAjaranController extends Controller
{
    public function index()
    {
        // $tahunAjarans = TahunAjaran::all();
        $tahunAjarans = TahunAjaran::orderby('tahun_mulai','desc')->orderBy('kode_ta','desc')->paginate(10);
        // $tahunAjarans = TahunAjaran::orderby('tahun_mulai','desc')->get();
        // return view('tahun_ajaran.index', compact('tahunAjarans'));
        return view('tahun_ajaran.index', ['tahunAjarans' =>$tahunAjarans]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'tahun_mulai' => 'required|integer',
            'tahun_selesai' => 'required|integer',
            'kode_ta' => 'required|string',
        ]);
    
        // Simpan data baru ke dalam database
        $tahunAjaran = new TahunAjaran;
        $tahunAjaran->tahun_mulai = $request->tahun_mulai;
        $tahunAjaran->tahun_selesai = $request->tahun_selesai;
        $tahunAjaran->kode_ta = $request->kode_ta;
        $tahunAjaran->save();


        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Data Tahun Ajaran Baru: ' . $request->kode_ta, // Deskripsi aktivitas
            'object_id' => $tahunAjaran->id_ta, // ID murid yang ditambahkan
            'object_type' => 'App\Models\TahunAjaran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);
    
        // Kirim respon JSON sebagai tanda berhasil
        return response()->json(['success' => true]);
    }


    public function update(Request $request, $id_ta)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id_ta);
   
        $oldData = $tahunAjaran->toArray();

        $tahunAjaran->update([
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'kode_ta' => $request->kode_ta,


        ]);

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Tahun Ajaran: ' . $oldData['kode_ta'], // Deskripsi aktivitas
            'object_id' => $id_ta, // ID murid yang diperbarui
            'object_type' => 'App\Models\TahunAjaran', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        return response()->json(['success' => true]);
    }
 


    public function destroy($id_ta)
{
    // return "Halo";
    $tahunAjaran = TahunAjaran::find($id_ta);

    $oldData = $tahunAjaran->toArray();

    $time = Carbon::now()->format('Y-m-d H:i:s');

    ActivityLog::create([
        'actor_id' => Auth::user()->id, // ID user administrator yang login
        'actor_type' => 'App\Models\User', // Tabel asal aktor
        'action' => 'delete', // Aksi CRUD (update)
        'description' => 'Menghapus data tahun ajaran: ' . $oldData['kode_ta'], // Deskripsi aktivitas
        'object_id' => $id_ta, // ID murid yang diperbarui
        'object_type' => 'App\Models\TahunAjaran', // Tabel/model yang menjadi objek
        'time_stamp' => $time, // Tabel/model yang menjadi objek
    ]);

    $tahunAjaran->delete();
    return redirect()->back()->with('success', 'Data pelanggaran siswa berhasil dihapus.');
}





// Method untuk transisi -- Start 

    public function transisi()
    {
        $tahunAjaran = TahunAjaran::all();
        return view('tahun_ajaran.transisi', compact('tahunAjaran'));
    }


    public function getKelasLama(Request $request)
    {
        $kelas = Kelas::where('id_ta', $request->kode_ta_lama)->get();

        $response = $kelas->map(function($kelas) {
            return [
                'id_kelas' => $kelas->id_kelas,
                'id_ta' => $kelas->id_ta,
                'nama_kelas' => $kelas->nama_kelas,
                'id_guru' => $kelas->guru->id_guru,
                'nama_guru' => $kelas->guru ? $kelas->guru->nama_guru : 'Guru tidak ditemukan',
                'kode_ta' => $kelas->tahunAjaran ? $kelas->tahunAjaran->kode_ta : 'Tahun ajaran tidak ditemukan',
            ];
        });
        return response()->json($response);
        // return response()->json([$response]);
    }



    public function prosesTransisi(Request $request)
{
    $kelasBaru = $request->input('kelasBaru'); //kelasBaru ini memiliki 2 string, yaitu id_kelas lama dan baru
    $id_ta_lama = $request->input('kode_ta_lama');
    $id_ta_baru = $request->input('kode_ta_baru');

    foreach ($kelasBaru as $kelas) {
        // ngambil data murid lama
        $murids = Murid::where('id_kelas', $kelas['id_kelas_lama'])
                        ->where('id_ta', $id_ta_lama)
                        ->get();

        foreach ($murids as $murid) {
            // masukan data murid lama ke arsip
            Arsip::create([
                'id_murid' => $murid->id_murid,
                'id_kelas' => $murid->id_kelas,
                'id_ta'    => $murid->id_ta
            ]);

            // Update data murid dengan yang baru
            $murid->update([
                'id_kelas' => $kelas['id_kelas_baru'],
                'id_ta'    => $id_ta_baru
            ]);
        }
    }
    $kode_ta_lama = TahunAjaran::where('id_ta',$id_ta_lama)->first();
    $kode_ta_baru = TahunAjaran::where('id_ta',$id_ta_baru)->first();
    $time = Carbon::now()->format('Y-m-d H:i:s');
    
    // Catat log aktivitas
    ActivityLog::create([
        'actor_id' => Auth::user()->id, // ID user administrator yang login
        'actor_type' => 'App\Models\User', // Tabel asal aktor
        'action' => 'transisi', // Aksi CRUD (update)
        'description' => 'Melakukan Transisi Tahun Ajaran dari ' . $kode_ta_lama->kode_ta  . ' -> ' . $kode_ta_baru->kode_ta, // Deskripsi aktivitas
        'object_id' => $id_ta_lama, // ID murid yang diperbarui
        'object_type' => 'App\Models\TahunAjaran', // Tabel/model yang menjadi objek
        'time_stamp' => $time, 
    ]);

    return response()->json(['message' => 'Transisi berhasil dilakukan']);
}
// Method untuk transisi -- End

}

