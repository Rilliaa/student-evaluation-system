<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil semua data guru
        $gurus = DB::table('gurus')->get();

        // Update kolom password dengan nilai yang dienkripsi menggunakan NIP
        foreach ($gurus as $guru) {
            DB::table('gurus')
                ->where('id_guru', $guru->id_guru)
                ->update(['password' => Hash::make($guru->nip)]);
        }
    }
}
