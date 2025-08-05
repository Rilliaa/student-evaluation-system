<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MuridPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil semua data guru
        $murids = DB::table('murids')->get();

        // Update kolom password dengan nilai yang dienkripsi menggunakan NIP
        foreach ($murids as $data) {
            DB::table('murids')
                ->where('id_murid', $data->id_murid)
                ->update(['password' => Hash::make($data->nisn)]);
        }
    }
}
