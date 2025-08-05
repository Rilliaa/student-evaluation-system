<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Roles;

class RoleController extends Controller
{
    // Method untuk menampilkan semua data roles
    public function index()
    {
        $roles = Roles::all();
        return view('roles.index', compact('roles'));
    }

    // Method untuk menampilkan form tambah role
    public function create()
    {
        return view('roles.create');
    }

    // Method untuk menyimpan data role yang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_roles' => 'required'
            
        ]);
       
        Roles::create([
            'nama_roles' => $request->nama_roles
        ]);
        return redirect()->route('roles.index')->with('success_message', 'Berhasil menambah Role baru');
    }
    


    public function edit($id_roles)
    { //modifikasi
        $role = Roles::find($id_roles);
        if (!$role) return redirect()->route('roles.index')
            ->with('error_message', 'Role dengan id '.$id_roles.' tidak ditemukan');
        
        return view('roles.edit', [
            'role' => $role
        ]);
    }



    public function update(Request $request, $id_roles)
{ 
    // Modifikasi
    $role = Roles::findOrFail($id_roles);

    $request->validate([
        'nama_roles' => 'required'
        
    ]);
    $role->update([
        'nama_roles' => $request->nama_roles
    ]);
   
    return redirect()->route('roles.index')
        ->with('success_message', 'Berhasil mengubah Role');
}


    public function destroy(Request $request, $id_roles)
    {
        $role = Roles::findOrFail($id_roles);
        $role->delete();
        return redirect()->route('roles.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
