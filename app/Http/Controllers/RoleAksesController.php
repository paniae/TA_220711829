<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Akses;
use Illuminate\Support\Facades\DB;

class RoleAksesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Akses::with('role')->get();
        
        return view('role.kelolaRoleAkses', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:255|unique:role,nama_role',
        ]);

        Role::create([
            'nama_role' => $request->nama_role,
        ]);

        return redirect()->back()->with('success', 'Role baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_role' => 'required|string|max:255|unique:role,nama_role,' . $id . ',id_role',
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'nama_role' => $request->nama_role,
        ]);

        return redirect()->back()->with('success', 'Nama role berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        
        if ($role->pengguna()->count() > 0) {
            return redirect()->back()->with('error', 'Role tidak bisa dihapus karena masih digunakan oleh pengguna!');
        }

        $role->delete();

        return redirect()->back()->with('success', 'Role berhasil dihapus!');
    }

    public function assignRole(Request $request)
    {
        $request->validate([
            'id_role' => 'required|exists:role,id_role',
            'id_akses' => 'required|exists:akses,id_akses',
        ]);

        $role = Role::findOrFail($request->id_role);
        
        // Cek jika relasi sudah ada
        if ($role->akses()->where('role_akses.id_akses', $request->id_akses)->exists()) {
            return redirect()->back()->with('error', 'Role tersebut sudah memiliki hak akses ini!');
        }

        $role->akses()->attach($request->id_akses);

        return redirect()->back()->with('success', 'Hak akses berhasil diberikan ke Role!');
    }

    public function revokeRole($id_role, $id_akses)
    {
        $role = Role::findOrFail($id_role);
        $role->akses()->detach($id_akses);

        return redirect()->back()->with('success', 'Hak akses berhasil dicabut dari Role!');
    }
}
