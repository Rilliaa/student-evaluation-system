<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\TahunAjaran;



class RincianController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::orderby('tahun_mulai','desc')->orderBy('kode_ta','desc')->get();
        $kelas = Kelas::orderBy('id_kelas')->paginate(10);
        $guru= Guru::all();
        return view('rincians.index', [
            'kelas'=>$kelas,
            'tahunAjaran' => $tahunAjaran,
            'guru' => $guru
        ]);
    }
}
