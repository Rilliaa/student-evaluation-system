<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MuridController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RincianController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JamController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\PelanggaranSiswaController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\PrestasiSiswaController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\PengaturanAkunController;

// Rute 
// Untuk melihat nilai rincians/index.blade.php -> kelas/show.blade.php -> murids/detail.blade.php
// Untuk melihat Kehadiran kehadirans/rincian.blade.php -> kelas/rincian.blade.php 

// Default route
Route::get('/', function () {
    return view('auth/login');
});

// Authentication routes
Auth::routes();

// Rute User -- start
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth:web'); // Gunakan guard default "web" untuk admin

Route::get('/modul/guru/dashboard', [App\Http\Controllers\GuruController::class, 'dashboard'])
    ->name('dashboard.guru')
    ->middleware('auth:guru'); // Gunakan guard "guru"

// Rute untuk murid
Route::get('/modul/murid/dashboard', [App\Http\Controllers\MuridController::class, 'dashboard'])
    ->name('dashboard.murid')
    ->middleware('auth:murid'); // Gunakan guard "murid"

// Rute untuk wali murid (masih dikosongkan)
Route::get('/modul/dashboard/ortu', [App\Http\Controllers\OrtuController::class, 'dashboard'])
    ->name('dashboard.ortu')
    ->middleware('auth:wali'); // Gunakan guard "wali"

// Home route for authenticated users


// Rute Global yang bisa diakses --Start
Route::get('/murids/kehadiran/grafik/{id}/{id_murid}',[MuridController::class,'grafikkehadiran'])->name('murids.grafik-kehadiran');
Route::get('/murids/{id_murid}/grafikline', [MuridController::class, 'grafikline'])->name('murids.grafik-line');
Route::get('/murids/kehadiran-by-sesi', [KehadiranController::class,'kehadiranbysesi'])->name('murids.kehadiranbysesi');
Route::get('/murids/{id_murid}/grafiknilai', [MuridController::class, 'grafiknilai'])->name('murids.grafik-nilai');
Route::POST('/modul/murid/get-nilai-mapel/{id}/{id_murid}',[MuridController::class,'modulgetnilai'])->name('modul.get.nilai');
Route::get('/kelas/byTahunAjaran', [KelasController::class, 'getKelasByTahunAjaran'])->name('kelas.byTahunAjaran');
// Rute Global yang bisa diakses --End



// Rute user murid --start
Route::middleware('auth:murid')->group(function() {
    Route::get('/modul/murid/daftar-pelanggaran/{id_murid}',[MuridController::class,'modulpelanggaran'])->name('modul.murid.pelanggaran');
    Route::get('/modul/murid/daftar-prestasi/{id_murid}',[MuridController::class,'modulprestasi'])->name('modul.murid.prestasi');
    Route::get('/modul/murid/kehadiran/{id_murid}',[MuridController::class,'modulkehadiran'])->name('modul.murid.kehadiran');
    Route::get('/modul/murid/nilai/{id_murid}',[MuridController::class,'modulnilai'])->name('modul.murid.nilai');
    Route::get('/modul/murid/jadwal/{id_murid}',[MuridController::class,'moduljadwal'])->name('modul.murid.jadwal');
   
    Route::get('/modul/murid/pengaturan-akun/{id_murid}',[PengaturanAkunController::class,'modulmurid'])->name('modul.murid.pengaturan-akun');
    Route::post('/modul/murid/pengaturan-akun/update-password', [PengaturanAkunController::class, 'updatemurid'])->name('modul.murid.password.update');
});
// Rute user murid --End

// Rute user Wali murid --start
Route::middleware('auth:wali')->group(function() {
    Route::get('/modul/wali-murid/daftar-pelanggaran/{id_murid}',[OrtuController::class,'modulpelanggaran'])->name('modul.murid.pelanggaran');
    Route::get('/modul/wali-murid/daftar-prestasi/{id_murid}',[OrtuController::class,'modulprestasi'])->name('modul.murid.prestasi');
    Route::get('/modul/wali-murid/kehadiran/{id_murid}',[OrtuController::class,'modulkehadiran'])->name('modul.murid.kehadiran');
    Route::get('/modul/wali-murid/nilai/{id_murid}',[OrtuController::class,'modulnilai'])->name('modul.murid.nilai');
   
    Route::get('/modul/wali-murid/pengaturan-akun/{id_ortu}',[PengaturanAkunController::class,'modulortu'])->name('modul.wali-murid.pengaturan-akun');
    Route::post('/modul/wali-murid/pengaturan-akun/update-password', [PengaturanAkunController::class, 'updateortu'])->name('modul.wali-murid.password.update');
});
// Rute user Wali murid --End

// Rute user guru --start
Route::middleware('auth:guru')->group(function() {
   Route::get('/modul/guru/jadwal-guru/{id_guru}',[GuruController::class,'moduljadwal'])->name('modul.guru.jadwal');
   Route::get('/modul/guru/get-jadwal',[GuruController::class, 'modulgetjadwal'])->name('modul.getjadwal');
   Route::get('/modul/guru/detail-murid/{id_guru}',[GuruController::class,'moduldetailmurid'])->name('modul.guru.detail-murid');
   Route::get('/modul/guru/detail/{id_kelas}/{id_ta}/{id_guru}',[GuruController::class,'moduldetail'])->name('modul.guru.detail');
   Route::get('/modul/guru/murid-detail/{id_guru}/{id_murid}/{id_ta}/{id_kelas}', [GuruController::class, 'muriddetail'])->name('modul.murids.detail'); 
   Route::get('/modul/guru/kelas-saya/{id_guru}', [GuruController::class, 'modulkelassaya'])->name('modul.guru.kelas-saya'); 
   Route::get('/modul/guru/get-kelas', [GuruController::class, 'modulgetkelas'])->name('modul.get.kelas'); 
   Route::get('/modul/guru/kelas/daftar-murid/{id_kelas}/{id_guru}', [GuruController::class, 'moduldaftarmurid'])->name('modul.daftar-murid'); 
   Route::get('/modul/guru/nilai/kelola-nilai/{id_murid}/{id_kelas}/{id_guru}', [GuruController::class, 'modulkelolanilai'])->name('modul.kelola.nilai'); 
 
   Route::get('/modul/guru/nilai/versi-2/{id_guru}', [GuruController::class, 'modulnilai2'])->name('modul.nilai2'); 
   Route::get('/modul/guru/nilai/get-data', [GuruController::class, 'modulgetdata'])->name('modul.getdata'); 


   Route::post('/nilai-store-data', [NilaiController::class, 'store'])->name('nilai.store-data');
   Route::put('/update-data/{id_nilai}', [NilaiController::class, 'update'])->name('nilai.update-data'); 
   Route::delete('/guru-nilai-delete-data/{id_nilai}', [NilaiController::class, 'destroy'])->name('nilai.destroy-data');
   
   Route::get('/modul/guru/pengaturan-akun/{id_guru}',[PengaturanAkunController::class,'modulguru'])->name('modul.guru.pengaturan-akun');
   Route::post('/modul/guru/pengaturan-akun/update-password', [PengaturanAkunController::class, 'updateguru'])->name('modul.guru.password.update');
   Route::get('/modul/guru/kehadiran/{id_ta}/{id_kelas}/{id_guru}', [GuruController::class, 'modulkehadiran'])->name('modul.kehadiran'); 

   Route::get('/modul/guru/cek-kehadiran', [KehadiranController::class, 'cekKehadiran'])->name('modul.guru.cekKehadiran');
   Route::get('/modul/guru/getKehadiranByMurid', [KehadiranController::class, 'getKehadiranByMurid'])->name('modul.guru.getKehadiranByMurid');
   Route::post('/modul/guru/store-kehadiran', [KehadiranController::class, 'store'])->name('modul.guru.kehadiran.store');
   Route::put('/modul/guru/update-kehadiran/{id}', [KehadiranController::class, 'update'])->name('modul.guru.kehadiran.update');
 
});
// Rute user guru --End






Route::middleware('auth:web')->group(function () {
        
    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('index');
    Route::get('/transisi-tahun-ajaran', [TahunAjaranController::class, 'transisi'])->name('tahunajaran.transisi');
    Route::post('/store-tahun-ajaran', [TahunAjaranController::class, 'store'])->name('tahun-ajaran.store');
    Route::put('/tahun-ajaran-update/{id}', [TahunAjaranController::class, 'update'])->name('tahun-ajaran.update');
    Route::delete('/tahun-ajaran-delete/{id}', [TahunAjaranController::class, 'destroy'])->name('tahun-ajaran.destroy');
    
    Route::get('/transisi-tahun-ajaran', [TahunAjaranController::class, 'transisi'])->name('transisi');
    Route::post('/getKelasLama', [TahunAjaranController::class, 'getKelasLama'])->name('getKelasLama');
    Route::post('/transisi-tahun-ajaran', [TahunAjaranController::class, 'prosesTransisi'])->name('prosesTransisi');
    Route::post('/getKelasBaru', [TahunAjaranController::class, 'getKelasBaru'])->name('getKelasBaru');



    Route::post('/atur-tahun-ajaran-baru', [App\Http\Controllers\HomeController::class, 'aturTahunAjaranBaru'])->name('atur.tahun.ajaran.baru');
    /////
    Route::get('/rincians/nilai', [RincianController::class, 'index'])->name('rincians.index'); //untuk menampilkan index nilai, rute untuk menampilkan rincian nilai dari sini > kelas.show > murid.detail
    
    
    Route::get('/sesi', [SesiController::class, 'index'])->name('sesi.index');
    Route::post('/simpan-sesi-pembelajaran',[SesiController::class,'simpanSesiPembelajaran'])->name('simpanSesiPembelajaran');
    Route::get('/filter', [SesiController::class, 'filterByTanggal'])->name('filterByTanggal');
    Route::post('/cek-tanggal', [SesiController::class, 'cekTanggal'])->name('cekTanggal');
    Route::delete('/sesi/{id_sesi}', [SesiController::class,'destroy'])->name('sesi.destroy');
    Route::put('/update-sesi/{id}', [SesiController::class,'update'])->name('sesi.update');
    Route::get('/get-sesi',[SesiController::class,'getSesi'])->name('getSesi');
    
    Route::get('/murids', [MuridController::class, 'index'])->name('murids.index');
    Route::get('/murids/search', [MuridController::class, 'search'])->name('murids.search');
    Route::post('/murids/store', [MuridController::class, 'store'])->name('murids.store');
    Route::get('/murid-detail/{id_murid}/{id_ta}/{id_kelas}', [MuridController::class, 'detail'])->name('murids.detail'); //rute untuk rincian nilai
    Route::post('/getkelas', [MuridController::class, 'getKelas'])->name('murid.getkelas');
    Route::get('/murids/livesearch', [MuridController::class, 'livesearch'])->name('murid.livesearch');
    Route::get('/murid/byTahunAjaran', [MuridController::class, 'getByTahunAjaran'])->name('murid.byTahunAjaran');
    Route::get('/murids/edit/{id}', [MuridController::class, 'edit'])->name('edit.murid');
    Route::delete('/murids/destroy/{id}', [MuridController::class, 'destroy'])->name('murids.destroy');
    route::get('/murids/grafik/{id}',[MuridController::class,'grafikshow'])->name('murids.grafik');
    // route::get('/murids/kehadiran/grafik/{id}/{id_murid}',[MuridController::class,'grafikkehadiran'])->name('murids.grafik-kehadiran');
    
    
    Route::get('/users', [UserController::class, 'index'])->name('users.index'); //untuk menampilkan index nilai, rute untuk menampilkan rincian nilai dari sini > kelas.show > murid.detail
    Route::get('/user-store-data', [UserController::class, 'store'])->name('users.store'); //untuk menampilkan index nilai, rute untuk menampilkan rincian nilai dari sini > kelas.show > murid.detail
    Route::delete('/users-destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    
    
    Route::get('/gurus', [GuruController::class, 'index'])->name('gurus.index'); 
    Route::post('/gurus/store', [GuruController::class, 'store'])->name('gurus.store');
    Route::delete('/gurus/del/{guru}', [GuruController::class, 'destroy'])->name('gurus.destroy');
    Route::get('/gurus/{guru}/edit', [GuruController::class, 'edit'])->name('gurus.edit'); // Menampilkan form edit guru
    Route::put('/gurus/{guru}', [GuruController::class, 'update'])->name('gurus.update'); 
    Route::get('/gurus/livesearch', [GuruController::class, 'livesearch'])->name('guru.livesearch');
    Route::get('/search-guru', [GuruController::class, 'search'])->name('guru.search');
    // Route::get('/prestasi/search', [PrestasiController::class, 'search'])->name('prestasi.search');
  


    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit'); 
    Route::put('/roles-update/{role}', [RoleController::class, 'update'])->name('roles.update'); 
    
    Route::post('/ortus/store', [OrtuController::class, 'store'])->name('ortus.store');
    Route::delete('/ortus/{ortu}', [OrtuController::class, 'destroy'])->name('ortus.destroy');
    Route::get('/ortus/{ortu}/edit', [OrtuController::class, 'edit'])->name('ortus.edit'); 
    Route::put('/ortus/{ortu}', [OrtuController::class, 'update'])->name('ortus.update'); 
    Route::get('/ortus/livesearch', [OrtuController::class, 'livesearch'])->name('ortus.livesearch');
    Route::get('/ortus', [OrtuController::class, 'index'])->name('ortus.index');
    Route::get('/ortu/detail/{id}', [OrtuController::class, 'show'])->name('ortus.show');
    
    
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::delete('/kelas/delete/{kelas}', [KelasController::class, 'destroy'])->name('kelasdestroy');
    Route::get('/kelas/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit'); 
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('kelas.update'); 
    Route::get('/kelas-kehadiran/{id_kelas}/{id_ta}', [KelasController::class, 'kehadiran'])->name('kelas.kehadiran');
    Route::get('/kelas/searchguru', [KelasController::class, 'searchguru'])->name('kelas.searchguru');
    Route::get('/kelas/{id_kelas}/{id_ta}', [KelasController::class, 'show'])->name('kelas.show');
    Route::get('/search/kelas/{id_ta}', [KelasController::class, 'search'])->name('kelas.search');
       

    
    Route::post('/mapels', [MapelController::class, 'store'])->name('mapels.store');
    Route::delete('/mapels-destroy/{mapel}', [MapelController::class, 'destroy'])->name('mapels.destroy');
    Route::get('/mapels/{mapel}/edit', [MapelController::class, 'edit'])->name('mapels.edit'); 
    Route::put('/mapels-update/{mapel}', [MapelController::class, 'update'])->name('mapels.update'); 
    Route::get('/mapel-search',[MapelController::class,'search'])->name('mapels.search');
    
    
    
    Route::post('/nilai-store', [NilaiController::class, 'store'])->name('nilai.store');
    Route::delete('/nilai-delete/{id_nilai}', [NilaiController::class, 'destroy'])->name('nilai.destroy');
    Route::get('/nilais/{nilai}/edit', [NilaiController::class, 'edit'])->name('nilais.edit');
    Route::put('/nilai-update/{id_nilai}', [NilaiController::class, 'update'])->name('nilai.update'); 
    // Route::put('/nilais/', [NilaiController::class, 'rekap'])->name('nilais.rekap'); 
    
    Route::get('/jam-pelajarans', [JamController::class, 'index'])->name('jam.index');
    Route::post('/jam', [JamController::class, 'store'])->name('jam.store');
    Route::delete('/jam/{id_jam}', [JamController::class, 'destroy'])->name('jam.destroy');
    Route::get('/jam/{id_jam}/edit', [JamController::class, 'edit'])->name('jam.edit');
    Route::put('/jam/{jam}', [JamController::class, 'update'])->name('jam.update');
    Route::get('/jam/fetch', [JamController::class, 'fetch'])->name('jam.fetch');
    
    
    
    Route::get('/jadwal-pelajarans', [JadwalController::class, 'index'])->name('jadwal_pelajarans.index');
    Route::get('/jadwal-rincian/{id_kelas}/{id_ta}', [JadwalController::class,'show'])->name('jadwal.rincian');
    Route::get('/jadwalPelajarans', [JadwalController::class, 'index'])->name('jadwalPelajarans.index');
    Route::post('/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal-pelajaran/{id_jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::post('/simpan-data', [JadwalController::class, 'simpanData'])->name('simpanData');
    Route::delete('jadwal/delete/{id_jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::post('/getguru', [JadwalController::class, 'getguru'])->name('getguru');
    Route::post('/getguruedit', [JadwalController::class, 'getguruedit'])->name('getguruedit');
    
    
    
    // Rute untuk menampilkan halaman rincian kehadiran
    Route::get('/kehadirans', [KehadiranController::class, 'index'])->name('kehadirans.index');
    
    Route::get('/rincian-kehadiran', [KehadiranController::class, 'rincian'])->name('rincian-kehadiran.index');
    Route::get('/get-id-murid-by-name', [KehadiranController::class, 'getIdMuridByName'])->name('get.id.murid.by.name');
    Route::get('/get-available-dates', [KehadiranController::class, 'getAvailableDates'])->name('GetTanggal');
    Route::get('/tes-kehadiran-murid',[KehadiranController::class,'teskehadiran'])->name('kehadiran.tes');
    Route::get('/filter-kehadiran/{id_kelas}', [KehadiranController::class, 'filterKehadiran'])->name('filter.kehadiran');
    Route::get('/cek-kehadiran', [KehadiranController::class, 'cekKehadiran'])->name('cekKehadiran');
    Route::get('/getKehadiranByMurid', [KehadiranController::class, 'getKehadiranByMurid'])->name('getKehadiranByMurid');
    Route::get('/kehadiranGetMurid', [KehadiranController::class, 'kehadiranGet'])->name('KehadiranGet');
    Route::post('/store-kehadiran', [KehadiranController::class, 'store'])->name('kehadiran.store');
    Route::put('/update-kehadiran/{id}', [KehadiranController::class, 'update'])->name('kehadiran.update');
    Route::delete('/kehadiran-delete/{id}', [KehadiranController::class, 'destroy'])->name('kehadiran.destroy');
    
    
    
    
    
    Route::get('/daftar-pelanggaran', [PelanggaranController::class,'index'])->name('daftar.pelanggaran');
    Route::post('/pelanggaran', [PelanggaranController::class, 'store'])->name('pelanggaran.store');
    // Route::get('/pelanggaran/{id_pelanggaran}/edit', [PelanggaranController::class, 'edit'])->name('pelanggaran.edit');
    Route::put('/pelanggaran/{id}', [PelanggaranController::class, 'update'])->name('pelanggaran.update');
    // Route::put('/pelanggaran-destroy/{id_pelanggaran}/', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
    Route::delete('/pelanggaran-destroy/{id_pelanggaran}/', [PelanggaranController::class, 'destroy'])->name('pelanggaran.destroy');
    Route::get('/pelanggaran/search', [PelanggaranController::class, 'search'])->name('pelanggaran.search');
    Route::post('/ortu/gettahun', [PelanggaranSiswaController::class, 'gettahun'])->name('gettahun');
    
    
    Route::post('/pelanggaran/getkelas', [PelanggaranSiswaController::class, 'getkelas'])->name('getkelas');
    Route::get('/pelanggaransiswa', [PelanggaranSiswaController::class, 'index'])->name('pelanggaran_siswa.index');
    Route::POST('/siswapelanggar', [PelanggaranSiswaController::class, 'send'])->name('pelanggaran-siswa.send');
    Route::get('/detail-siswa-pelanggar/{id_murid}', [PelanggaranSiswaController::class, 'detail'])->name('pelanggaran-siswa.detail');
    Route::delete('/pelanggaran-siswa/{id_pelanggaran}/destroy', [PelanggaranSiswaController::class, 'destroy'])->name('pelanggaran-siswa.destroy');
    Route::put('/pelanggaran-siswa/{id}', [PelanggaranSiswaController::class, 'update'])->name('pelanggaran-siswa.update');
    
    
    
    
    Route::get('/daftar-prestasi', [PrestasiController::class,'index'])->name('prestasi.index');
    Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    Route::put('/prestasi/{id}', [PrestasiController::class, 'update'])->name('prestasi.update');
    Route::delete('/prestasi-destroy/{id_prestasi}/', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    // Route::put('/prestasi-destroy/{id_prestasi}/', [PrestasiController::class, 'destroy'])->name('prestasi.destroy');
    Route::get('/prestasi/search', [PrestasiController::class, 'search'])->name('prestasi.search');
    
    
    Route::post('/prestasi/getkelas', [PrestasiSiswaController::class, 'getkelas'])->name('getkelasprestasi');
    Route::get('/prestasi-siswa', [PrestasiSiswaController::class, 'index'])->name('prestasi-siswa.index');
    Route::POST('/siswa-prestasi', [PrestasiSiswaController::class, 'send'])->name('prestasi-siswa.send');
    Route::get('/detail-siswa-prestasi/{id_murid}', [PrestasiSiswaController::class, 'detail'])->name('prestasi-siswa.detail');
    Route::delete('/prestasi-siswa/{id_prestasi}/destroy', [PrestasiSiswaController::class, 'destroy'])->name('prestasi-siswa.destroy');
    Route::put('/prestasi-siswa/{id}', [PrestasiSiswaController::class, 'update'])->name('prestasi-siswa.update');
    
    
    Route::get('/cek-log-aktivitas', [UserController::class, 'ceklog'])->name('admin.cek-log');

    
    Route::get('/pengaturan-akun', [PengaturanAkunController::class,'index'])->name('pengaturanAkun.index');
    Route::post('/pengaturan-akun/update-password', [PengaturanAkunController::class, 'updatePassword'])->name('password.update');
    
});






Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');



// Resource routes for gurus, kehadirans, kelas, mapels, murids, nilais, ortus, and roles
Route::middleware('auth:web')->group(function () {
    Route::resource('pelanggaran-siswa', App\Http\Controllers\PelanggaranSiswaController::class);
    Route::resource('pengaturan-akun', App\Http\Controllers\PengaturanAkunController::class);
    Route::resource('prestasi-siswa', App\Http\Controllers\PrestasiSiswaController::class);
    Route::resource('tahun_ajaran', App\Http\Controllers\TahunAjaranController::class);
    Route::resource('pelanggaran', App\Http\Controllers\PelanggaranController::class);
    Route::resource('kehadirans', App\Http\Controllers\KehadiranController::class);
    Route::resource('prestasi', App\Http\Controllers\PrestasiController::class);
    Route::resource('rincian', App\Http\Controllers\RincianController::class);
    Route::resource('jadwal', App\Http\Controllers\JadwalController::class);
    Route::resource('mapels', App\Http\Controllers\MapelController::class);
    Route::resource('murids', App\Http\Controllers\MuridController::class);
    Route::resource('nilais', App\Http\Controllers\NilaiController::class);
    Route::resource('kelas', App\Http\Controllers\KelasController::class);
    Route::resource('gurus', App\Http\Controllers\GuruController::class);
    Route::resource('ortus', App\Http\Controllers\OrtuController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('sesi', App\Http\Controllers\SesiController::class);
    Route::resource('jam', App\Http\Controllers\JamController::class);
});



