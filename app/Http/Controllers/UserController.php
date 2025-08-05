<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use App\Models\ActivityLog;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function create()
{
    $roles = Roles::all();
    return view('users.create', compact('roles'));
}
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'no_hp' => 'required',
        'id_role' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed'
    ]);
    $array = $request->only([
        'name', 
        'email', 
        'password',
        'id_role',
        'no_hp'
    ]);
    $array['password'] = bcrypt($array['password']);
    // bycrypt = hashing
    $user = User::create($array);
    return redirect()->route('users.index')
        ->with('success_message', 'Berhasil menambah user baru');
}
public function edit($id)
{
    $user = User::find($id);
    $roles = Roles::all();
    if (!$user) return redirect()->route('users.index')
        ->with('error_message', 'User dengan id'.$id.' tidak ditemukan');
    return view('users.edit', [
        'user' => $user,
        'roles' => $roles
    ]);
}
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'no_hp' => 'required',
        'id_role' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'sometimes|nullable|confirmed'
    ]);
    $user = User::find($id);
    $user->name = $request->name;
    $user->no_hp = $request->no_hp;
    $user->role = $request->id_role;
    $user->email = $request->email;
    if ($request->password) $user->password = bcrypt($request->password);
    $user->save();
    return redirect()->route('users.index')
        ->with('success_message', 'Berhasil mengubah user');
}



public function destroy(Request $request, $id)
{
    $user = User::find($id);

    if ($id == Auth()->user()->id) 
        return redirect()->back()->with('error_message', 'Anda tidak dapat menghapus diri sendiri.');

    if ($user) {
        // $this->authorize('delete', $user); 
        $user->delete();
    }

    return redirect()->back()->with('success_message', 'Data berhasil dihapus.');
}



// public function destroy(Request $request, $id)
// {
//     $user = User::find($id);
//     if ($id == $request->user()->id) return redirect()->route('users.index')
//         ->with('error_message', 'Anda tidak dapat menghapus diri sendiri.');

//     if ($user) $user->delete();
//     return redirect()->route('users.index')
//         ->with('success_message', 'Berhasil menghapus user');
// }

    public function ceklog()
    {
        $logs =  ActivityLog::orderby('id',"desc")->with(['actor', 'object'])->paginate(10);
        return view('cek_log', compact('logs'));
    }

}

