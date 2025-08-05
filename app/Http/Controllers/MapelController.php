<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MapelController extends Controller
{
    // Method untuk menampilkan semua mapel
    public function index()
{
    // Mengambil data mapel beserta data terkait dari relasi many-to-many dengan guru
    $mapels = Mapel::with('gurus')->orderby('nama_mapel')->paginate(10);
    // $mapels = Mapel::with('gurus')->orderby('nama_mapel')->get();

    return view('mapels.index', ['mapels'=>$mapels]);
}

public function search(Request $request)
{
    // untuk search kategori menggunakan select2  dari produk/index.blade.php
    $data = Mapel::where('nama_mapel','LIKE','%'.request('q').'%')->orderBy("nama_mapel","asc")->get();
    return response()->json($data);
}


    // Method untuk menampilkan form tambah mapel
    public function create()
    {
        $gurus = Guru::all();
        return view('mapels.create', compact('gurus'));
    }

    
    // Method untuk menyimpan data mapel yang baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapels',
            'nama_mapel' => 'required',
            // 'id_guru' => 'nullable' // Guru bisa tidak diisi saat membuat mapel
        ],[
            'kode_mapel.required' => 'Kode Mata Pelajaran harus diisi',
            'kode_mapel.unique' => 'Kode Mata Pelajaran sudah ada',
            'nama_mapel.required' => 'Nama Mata Pelajaran harus diisi',
            
        ]);

        $mapel = Mapel::create([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'id_guru' => $request->id_guru
        ]);
        $time = Carbon::now()->format('Y-m-d H:i:s');

        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'create', // Aksi CRUD (create)
            'description' => 'Menambahkan Data Mapel baru: ' . $request->nama_mapel, // Deskripsi aktivitas
            'object_id' => $mapel->id_mapel, // ID murid yang ditambahkan
            'object_type' => 'App\Models\Mapel', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        // Redirect ke halaman yang ditentukan setelah menyimpan data
        return redirect()->route('mapels.index')->with(['success' => 'Data Berhasil Disimpan']);
    }

    // Method untuk menampilkan form edit mapel
    public function edit($id_mapel)
    {
        $mapel = Mapel::findOrFail($id_mapel);
        $gurus = Guru::all();
        return view('mapels.edit', [
            'mapel' => $mapel,
            'gurus' => $gurus
        ]);
    }

    // Method untuk menyimpan perubahan data mapel yang diedit
    public function update(Request $request, Mapel $mapel)
    {
        // Validasi data
        $request->validate([
            'kode_mapel' => 'required',
            'nama_mapel' => 'required',
            'id_guru' => 'nullable' // Guru bisa tidak diisi saat mengedit mapel
        ]);

        $oldData = $mapel->toArray();

        // Update data mapel ke database
        $mapel->update($request->all());

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'update', // Aksi CRUD (update)
            'description' => 'Memperbarui Data Mapel: ' . $oldData['nama_mapel'], // Deskripsi aktivitas
            'object_id' => $oldData['id_mapel'], // ID murid yang diperbarui
            'object_type' => 'App\Models\Mapel', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        // Redirect ke halaman yang ditentukan setelah menyimpan perubahan
        return redirect()->route('mapels.index')->with(['success' => 'Data Berhasil Diubah']);
    }

    // Method untuk menghapus data mapel
    public function destroy($id_mapel): RedirectResponse
    {
        // Hapus data mapel dari database
        $mapel = Mapel::findOrFail($id_mapel);

        
        $oldData = $mapel->toArray();

        $time = Carbon::now()->format('Y-m-d H:i:s');
    
        // Catat log aktivitas
        ActivityLog::create([
            'actor_id' => Auth::user()->id, // ID user administrator yang login
            'actor_type' => 'App\Models\User', // Tabel asal aktor
            'action' => 'delete', // Aksi CRUD (update)
            'description' => 'Menghapus Data Mapel: ' . $oldData['nama_mapel'], // Deskripsi aktivitas
            'object_id' => $id_mapel, // ID murid yang diperbarui
            'object_type' => 'App\Models\Mapel', // Tabel/model yang menjadi objek
            'time_stamp' => $time, 
        ]);

        $mapel->delete();
        // Redirect ke halaman yang ditentukan setelah menghapus data
        return redirect()->route('mapels.index')->with(['success' => 'Data Berhasil Dihapus']);
    }
}

