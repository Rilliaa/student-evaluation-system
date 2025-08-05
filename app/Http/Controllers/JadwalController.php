<?php

namespace App\Http\Controllers;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\JamPelajaran;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\TahunAjaran;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class JadwalController extends Controller
{
    // public function index()
    // {
    //     $kelas = Kelas::paginate(10);
    //     // $jadwal = JadwalPelajaran::all();
    //     return view('jadwal.index', ['kelas' => $kelas]);
    // }
    public function index()
    {
        // mengatur tampilan jadwals/index.blade.php
        $tahunAjaran = TahunAjaran::orderby('tahun_mulai','desc')->orderBy('kode_ta','desc')->get();
        $kelas = Kelas::orderBy('id_kelas')->paginate(10);
        $guru= Guru::all();
        return view('jadwal.index', [
            'kelas'=>$kelas,
            'tahunAjaran' => $tahunAjaran,
            'guru' => $guru
        ]);
    }
    
    
public function show(int $id_kelas, $id_ta)
{
    // untuk mengatur tampilan jadwals/rincian.blade.php
    // $ta = TahunAjaran::where('';)
    $jam = JamPelajaran::orderBy('id_jam')->orderBy('jam_ke')->get()->groupBy('hari');
    $daftar_kelas = Kelas::all();
    $jadwals = JadwalPelajaran::with('jampels')->where('id_kelas', $id_kelas)->get();

    // $kelas = Kelas::findOrFail($id_kelas);
    $kelas = Kelas::where('id_kelas',$id_kelas)->where('id_ta',$id_ta)->first();
    $mapels = Mapel::all();
    return view('jadwal.rincian', compact('jam', 'kelas', 'mapels', 'jadwals'));
}

public function store(Request $request)
{
    // Validasi data
    $request->validate([
        'id_mapel' => 'required',
        'id_guru' => 'required',
        'id_ta' => 'required',
        'id_kelas' => 'required',
        'id_jam' => 'required',
    ]);

    // Cek jadwal bentrok
    $jadwalBentrok = JadwalPelajaran::where('id_guru', $request->id_guru)
        ->where('id_jam', $request->id_jam)
        ->where('id_ta', $request->id_ta)
        ->where('id_kelas', '!=', $request->id_kelas)
        ->exists();

    if ($jadwalBentrok) {
        return response()->json([
            'success' => false,
            'message' => 'Jadwal bentrok. Guru tidak dapat berada di dua kelas yang berbeda pada waktu yang sama.',
        ]);
    }

    // Simpan data jadwal baru
    $jadwal = JadwalPelajaran::create($request->only(['id_ta', 'id_mapel', 'id_guru', 'id_kelas', 'id_jam']));

    // Ambil data tambahan untuk log
    $mapel = Mapel::findOrFail($request->id_mapel);
    $jamPelajaran = JamPelajaran::findOrFail($request->id_jam);
    $kelas = Kelas::findOrFail($request->id_kelas);
    $tahunAjaran = $kelas->tahunAjaran->kode_ta ?? 'Tidak Diketahui';

    // Data untuk log aktivitas
    $logData = [
        'kelas' => $kelas->nama_kelas,
        'tahunAjaran' => $tahunAjaran,
        'mapel' => $mapel->nama_mapel,
        'hari' => $jamPelajaran->hari,
    ];

    // Simpan log aktivitas
    ActivityLog::create([
        'actor_id' => Auth::user()->id,
        'actor_type' => 'App\Models\User',
        'action' => 'create',
        'description' => 'Menambahkan Data Jadwal Baru ke kelas ' . $logData['kelas'] . 
            ' (' . $logData['tahunAjaran'] . '), Mapel: ' . $logData['mapel'] . 
            ', untuk hari: ' . $logData['hari'],
        'object_id' => $jadwal->id_jadwal,
        'object_type' => 'App\Models\JadwalPelajaran',
        'time_stamp' => now()->format('Y-m-d H:i:s'),
    ]);

    // Kembalikan respons sukses
    return response()->json([
        'success' => true,
        'message' => 'Data berhasil disimpan.',
    ]);
}



public function update(Request $request, $id_jadwal)
{
    // Validasi data
    $request->validate([
        'id_mapel' => 'required',
        'id_guru' => 'required',
        'id_kelas' => 'required',
        'id_jam' => 'required',
        'id_ta' => 'required',
    ]);

    // Cek jadwal bentrok
    $jadwalBentrok = JadwalPelajaran::where('id_guru', $request->id_guru)
        ->where('id_jam', $request->id_jam)
        ->where('id_ta', $request->id_ta)
        ->where('id_kelas', '!=', $request->id_kelas)
        ->where('id_jadwal', '!=', $id_jadwal)
        ->exists();

    if ($jadwalBentrok) {
        return response()->json([
            'success' => false,
            'message' => 'Jadwal bentrok. Guru tidak dapat berada di dua kelas yang berbeda pada waktu yang sama.',
        ]);
    }

    // Ambil data jadwal lama sebelum di-update
    $jadwal = JadwalPelajaran::findOrFail($id_jadwal);
    $oldData = $jadwal->toArray();

    // Update data jadwal dengan input baru
    $jadwal->update($request->only(['id_ta', 'id_mapel', 'id_guru', 'id_kelas', 'id_jam']));

    // Ambil data tambahan untuk log
    $oldMapel = Mapel::find($oldData['id_mapel'])->nama_mapel ?? 'Tidak Diketahui';
    $oldHari = JamPelajaran::find($oldData['id_jam'])->hari ?? 'Tidak Diketahui';
    $oldKelas = Kelas::find($oldData['id_kelas'])->nama_kelas ?? 'Tidak Diketahui';
    $oldTahunAjaran = Kelas::find($oldData['id_kelas'])->tahunAjaran->kode_ta ?? 'Tidak Diketahui';

    $newMapel = Mapel::find($request->id_mapel)->nama_mapel ?? 'Tidak Diketahui';
    $newHari = JamPelajaran::find($request->id_jam)->hari ?? 'Tidak Diketahui';
    $newKelas = Kelas::find($request->id_kelas)->nama_kelas ?? 'Tidak Diketahui';
    $newTahunAjaran = Kelas::find($request->id_kelas)->tahunAjaran->kode_ta ?? 'Tidak Diketahui';

    // Susun deskripsi perubahan
    $description = 'Memperbarui Data Jadwal: ' . PHP_EOL .
        '- Mapel: ' . $oldMapel . ' -> ' . $newMapel . PHP_EOL .
        '- Hari: ' . $oldHari . ' -> ' . $newHari . PHP_EOL .
        '- Kelas: ' . $oldKelas . ' (' . $oldTahunAjaran . ') -> ' . $newKelas . ' (' . $newTahunAjaran . ')';

    // Simpan log aktivitas
    ActivityLog::create([
        'actor_id' => Auth::user()->id,
        'actor_type' => 'App\Models\User',
        'action' => 'update',
        'description' => $description,
        'object_id' => $jadwal->id_jadwal,
        'object_type' => 'App\Models\JadwalPelajaran',
        'time_stamp' => now()->format('Y-m-d H:i:s'),
    ]);

    // Kembalikan respons sukses
    return response()->json([
        'success' => true,
        'message' => 'Jadwal berhasil diperbarui.',
    ]);
}





public function getguru(Request $request)
{
    // untuk dropdown nama guru saat membuat jadwal
    $id_mapel = $request->id_mapel;
    $mapels = Mapel::where('id_mapel', $id_mapel)->get();
    foreach($mapels as $mapel){
        echo  "<option value='$mapel->id_guru'>{$mapel->gurus->nama_guru}</option>";
    }
}

public function getguruedit(Request $request)
{
    // sama aja kek diatas tapi untuk edit
    $mapel = $request->id_mapel_edit;
    $mapel_edit = Mapel::where('id_mapel', $mapel)->get();
    foreach($mapel_edit as $mapels){
        echo  "<option value='$mapels->id_guru'>{$mapels->gurus->nama_guru}</option>";
    }
}



public function destroy($id_jadwal)
{
    // Cari jadwal berdasarkan ID
    $jadwal = JadwalPelajaran::findOrFail($id_jadwal);

    // Ambil informasi jadwal untuk log sebelum dihapus
    $mapel = Mapel::find($jadwal->id_mapel)->nama_mapel ?? 'Tidak Diketahui';
    $hari = JamPelajaran::find($jadwal->id_jam)->hari ?? 'Tidak Diketahui';
    $kelas = Kelas::find($jadwal->id_kelas)->nama_kelas ?? 'Tidak Diketahui';
    $tahunAjaran = Kelas::find($jadwal->id_kelas)->tahunAjaran->kode_ta ?? 'Tidak Diketahui';

    // Susun deskripsi log
    $description = 'Menghapus Data Jadwal: ' . PHP_EOL .
        '- Mapel: ' . $mapel . PHP_EOL .
        '- Hari: ' . $hari . PHP_EOL .
        '- Kelas: ' . $kelas . ' (' . $tahunAjaran . ')';

    // Hapus jadwal
    $jadwal->delete();

    // Catat log aktivitas
    ActivityLog::create([
        'actor_id' => Auth::user()->id,
        'actor_type' => 'App\Models\User',
        'action' => 'delete', // Aksi CRUD (delete)
        'description' => $description,
        'object_id' => $id_jadwal,
        'object_type' => 'App\Models\JadwalPelajaran',
        'time_stamp' => now()->format('Y-m-d H:i:s'),
    ]);

    // Redirect dengan pesan sukses
    return redirect()->back()->with('success', 'Jadwal Pelajaran Berhasil dihapus!');
}

// public function destroy(Request $request, $id_jam)
// {
//     $jam = JadwalPelajaran::findOrFail($id_jam);
//     $jam->delete();
//     return redirect()->route('jadwal.rincian')->with(['success' => 'Data Berhasil Dihapus!']);
// }






}
