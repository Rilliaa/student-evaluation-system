<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Murid;
use app\Models\Ortu;
use app\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PengaturanAkunController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pengaturan-akun', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'current_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        // Cek apakah password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama tidak valid']);
        }

        // Update password dan nama
        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil diubah']);
    }

    public function modulmurid($id_murid)
    {
        $murid = Murid::find($id_murid);
        $user = Auth::user();
        return view('modul.murid.pengaturan-akun', compact('user','murid'));
    }

    public function updatemurid(Request $request)
    {
        $user = Auth::user();
    
        // Validasi input
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8', 
            // 'new_password' => 'required|min:8|confirmed', // Tambahkan konfirmasi password
        ])
        // , [
            // 'new_password.confirmed' => 'Konfirmasi password tidak sesuai dengan password baru.', // Custom error message
        // ])
        ;
    
        // Jika validasi gagal, return pesan error
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }
    
        // Cek apakah password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama tidak valid'], 400);
        }
    
        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return response()->json(['success' => true, 'message' => 'Password berhasil diubah'], 200);
    }
    
    public function modulortu($id_ortu)
    {
        $ortu = Ortu::find($id_ortu);
        $user = Auth::user();
        return view('modul.ortu.pengaturan-akun', compact('user','ortu'));
    }
    public function updateortu(Request $request)
    {
        $user = Auth::user();
    
        // Validate input
        $validator = Validator::make($request->all(), [
            'nama_ortu' => 'string|max:255',
            'no_hp' => 'string|max:20',
            'alamat' => 'string|max:255',
            'jenis_kelamin' => 'string',
            'current_password' => 'nullable|required_with:new_password',
            // 'new_password' => 'nullable|min:8|confirmed' ,
            'new_password' => 'nullable|min:8' ,
        ]);
    

        // Cek apakah password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama tidak valid']);
        }
        
        $user->nama_ortu = $request->nama_ortu;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        $user->jenis_kelamin = $request->jenis_kelamin;
    
        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
    
        // Save changes
        $user->save();
    
        return response()->json(['success' => true, 'message' => 'Data berhasil diubah'], 200);
    }
    public function modulguru($id_guru)
    {
        $guru = Guru::find($id_guru);
        $user = Auth::user();
        return view('modul.guru.pengaturan-akun', compact('user','guru'));
    }

    public function updateguru(Request $request)
    {
        $user = Auth::user();
    
        // Validate input
        $validator = Validator::make($request->all(), [
            'nama_guru' => 'string|max:255',
            'alamat' => 'string|max:255',
            'email' => 'email|max:255',
            'current_password' => 'nullable|required_with:new_password',
            // 'new_password' => 'nullable|min:8|confirmed',
            'new_password' => 'nullable|min:8',
        ]);
    
        // Jika validasi gagal, return pesan error
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        }
    
        // Cek apakah password lama diisi jika ada perubahan password
        if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama tidak valid'], 400);
        }
    
        // Update data akun
        $user->nama_guru = $request->input('nama_guru', $user->nama_guru);
        $user->email = $request->input('email', $user->email);
        $user->alamat = $request->input('alamat', $user->alamat);
    
        // Update password jika diisi
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }
    
        // Save changes
        $user->save();
    
        return response()->json(['success' => true, 'message' => 'Data berhasil diubah'], 200);
    }
    
}
