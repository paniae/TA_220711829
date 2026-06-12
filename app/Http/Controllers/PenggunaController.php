<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    public function profil()
    {
        $pengguna = Auth::user();
        return view('profil', compact('pengguna'));
    }

    public function updateProfil(Request $request)
    {
        $pengguna = Auth::user();

        $request->validate([
            'alamat_pengguna' => 'nullable|string',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'email_pengguna' => 'nullable|email|unique:pengguna,email_pengguna,' . $pengguna->id_pengguna . ',id_pengguna',
            'nomor_telepon_pengguna' => 'nullable|numeric|unique:pengguna,nomor_telepon_pengguna,' . $pengguna->id_pengguna . ',id_pengguna',
        ], [
            'email_pengguna.unique' => 'Email ini sudah terdaftar.',
            'nomor_telepon_pengguna.unique' => 'Nomor telepon ini sudah terdaftar.'
        ]);

        if ($request->has('alamat_pengguna')) {
            $pengguna->alamat_pengguna = $request->alamat_pengguna;
        }

        if ($request->has('email_pengguna')) {
            $pengguna->email_pengguna = $request->email_pengguna;
        }

        if ($request->has('nomor_telepon_pengguna')) {
            $pengguna->nomor_telepon_pengguna = $request->nomor_telepon_pengguna;
        }

        if ($request->hasFile('foto_profil')) {
            if ($pengguna->foto_profil) {
                $oldPath = ltrim(str_replace('/storage', '', $pengguna->foto_profil), '/');
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('foto_profil')->store('profil', 'public');
            $pengguna->foto_profil = Storage::url($path);
        }

        $pengguna->save();

        return response()->json([
            'alamat_pengguna' => $pengguna->alamat_pengguna,
            'email_pengguna' => $pengguna->email_pengguna,
            'nomor_telepon_pengguna' => $pengguna->nomor_telepon_pengguna,
            'foto' => $pengguna->foto_profil ?: null
        ]);
    }

    public function hapusFotoProfil()
    {
        $pengguna = Auth::user();

        if ($pengguna->foto_profil) {
            $oldPath = ltrim(str_replace('/storage', '', $pengguna->foto_profil), '/');
            Storage::disk('public')->delete($oldPath);
            $pengguna->foto_profil = null;
            $pengguna->save();
        }

        return response()->json(['success' => true]);
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'min:8', 'regex:/\d/', 'confirmed'],
        ], [
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.regex' => 'Password baru harus mengandung minimal satu angka.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $pengguna = Auth::user();

        if (!\Hash::check($request->old_password, $pengguna->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama salah.'], 400);
        }

        $pengguna->password = bcrypt($request->password);
        $pengguna->save();

        return response()->json(['success' => true, 'message' => 'Password berhasil diubah.']);
    }
    
    public function kelola(Request $request)
    {
        $pendingUsers = \App\Models\Pengguna::where('status_pengguna', 'pending')->get();
        
        // Cek kecocokan dengan data penduduk untuk pendaftar baru
        foreach ($pendingUsers as $pendaftar) {
            $pendaftar->dataPenduduk = \App\Models\Penduduk::where('nomor_induk_kependudukan', $pendaftar->nik)->first();
        }

        $roles = \App\Models\Role::all();
        
        $activeUsers = \App\Models\Pengguna::where('status_pengguna', 'aktif')
            ->with('role')
            ->orderBy('nama')
            ->get();
        
        return view('pengguna.kelolaPengguna', compact('pendingUsers', 'roles', 'activeUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => ['required', 'unique:pengguna,username', 'min:6', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/'],
            'nik' => 'required|unique:pengguna,nik',
            'nomor_telepon' => 'required|unique:pengguna,nomor_telepon_pengguna',
            'email' => 'required|email|unique:pengguna,email_pengguna',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'password' => 'required|min:6|confirmed',
            'id_role' => 'required|exists:role,id_role',
        ], [
            'username.unique' => 'Username sudah terdaftar dalam sistem.',
            'username.min' => 'Username minimal 6 karakter.',
            'username.regex' => 'Username harus mengandung huruf dan angka, serta tidak boleh mengandung spasi.',
            'nik.unique' => 'NIK sudah terdaftar dalam sistem.',
            'nomor_telepon.unique' => 'Nomor telepon sudah terdaftar dalam sistem.',
            'email.unique' => 'Email sudah terdaftar dalam sistem.',
            'email.required' => 'Email wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh setelah hari ini.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        \App\Models\Pengguna::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'nik' => $request->nik,
            'nomor_telepon_pengguna' => $request->nomor_telepon,
            'email_pengguna' => $request->email,
            'alamat_pengguna' => $request->alamat ?? '-',
            'jenis_kelamin_pengguna' => $request->jenis_kelamin,
            'tanggal_lahir_pengguna' => $request->tanggal_lahir,
            'password' => bcrypt($request->password),
            'status_pengguna' => 'aktif',
            'id_role' => $request->id_role,
        ]);

        return redirect()->back()->with('success', 'Akun berhasil ditambahkan dan langsung aktif.');
    }

    public function update(Request $request, $id)
    {
        $pengguna = \App\Models\Pengguna::findOrFail($id);
        
        $request->validate([
            'nama' => 'required',
            'username' => ['required', 'unique:pengguna,username,' . $id . ',id_pengguna', 'min:6', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/'],
            'nik' => 'required|unique:pengguna,nik,' . $id . ',id_pengguna',
            'nomor_telepon' => 'required|unique:pengguna,nomor_telepon_pengguna,' . $id . ',id_pengguna',
            'email' => 'nullable|email',
            'alamat' => 'nullable',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'password' => 'nullable|min:6|confirmed',
            'id_role' => 'required|exists:role,id_role',
        ], [
            'nik.unique' => 'NIK sudah terdaftar dalam sistem.',
            'nomor_telepon.unique' => 'Nomor telepon sudah terdaftar dalam sistem.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh setelah hari ini.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'nik' => $request->nik,
            'nomor_telepon_pengguna' => $request->nomor_telepon,
            'email_pengguna' => $request->email,
            'alamat_pengguna' => $request->alamat ?? '-',
            'jenis_kelamin_pengguna' => $request->jenis_kelamin,
            'tanggal_lahir_pengguna' => $request->tanggal_lahir,
            'id_role' => $request->id_role,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $pengguna->update($data);

        return redirect()->back()->with('success', 'Data akun ' . $pengguna->nama . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengguna = \App\Models\Pengguna::findOrFail($id);
        
        if ($pengguna->id_pengguna == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $nama = $pengguna->nama;
        $pengguna->delete();

        return redirect()->back()->with('success', 'Akun ' . $nama . ' berhasil dihapus.');
    }

    public function terima($id)
    {
        $pengguna = \App\Models\Pengguna::findOrFail($id);
        $pengguna->status_pengguna = 'aktif';
        $pengguna->save();

        if ($pengguna->email_pengguna) {
            try {
                \Illuminate\Support\Facades\Mail::to($pengguna->email_pengguna)->send(new \App\Mail\RegistrasiDiterimaMail($pengguna));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email terima registrasi ke ' . $pengguna->email_pengguna . ': ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Akun ' . $pengguna->nama . ' berhasil diterima/diaktifkan.');
    }

    public function tolak($id)
    {
        $pengguna = \App\Models\Pengguna::findOrFail($id);
        $nama = $pengguna->nama;

        if ($pengguna->email_pengguna) {
            try {
                \Illuminate\Support\Facades\Mail::to($pengguna->email_pengguna)->send(new \App\Mail\RegistrasiDitolakMail($pengguna));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal mengirim email tolak registrasi ke ' . $pengguna->email_pengguna . ': ' . $e->getMessage());
            }
        }

        $pengguna->delete();

        return redirect()->back()->with('success', 'Pendaftaran akun ' . $nama . ' telah ditolak dan dihapus.');
    }
}
