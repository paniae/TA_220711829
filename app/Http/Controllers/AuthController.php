<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nomor_telepon' => 'required',
            'password' => 'required',
        ]);

        $user = Pengguna::where('nomor_telepon_pengguna', $request->nomor_telepon)->first();

        if (!$user) {
            return back()->withErrors([
                'login' => 'Nomor telepon tidak ditemukan'
            ])->withInput();
        }

        if (!\Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'login' => 'Password salah'
            ])->withInput();
        }

        if ($user->status_pengguna != 'aktif') {
            return back()->withErrors([
                'login' => 'Akun belum aktif / belum disetujui'
            ]);
        }

        Auth::login($user);

        return $this->redirectByRole($user);
    }

    private function redirectByRole($user)
    {
        if ($user->isDukuh()) {
            return redirect()->route('beranda');
        }

        return redirect()->route('beranda');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function showRegister()
    {
        return view('auth.daftar');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:pengguna,nik',
            'nomor_telepon' => 'required|unique:pengguna,nomor_telepon_pengguna',
            'email' => 'required|email|unique:pengguna,email_pengguna',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'password' => ['required', 'min:8', 'confirmed', 'regex:/\d/'],
        ], [
            'nomor_telepon.unique' => 'Nomor telepon ini sudah terdaftar.',
            'nik.unique' => 'NIK ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh setelah hari ini.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password utama.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung minimal satu angka.',
        ]);

        $roleWarga = \App\Models\Role::where('nama_role', 'warga')->first();
        $idRoleWarga = $roleWarga ? $roleWarga->id_role : 1; // Fallback to 1 if not found

        $user = Pengguna::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'nomor_telepon_pengguna' => $request->nomor_telepon,
            'email_pengguna' => $request->email,
            'alamat_pengguna' => $request->alamat,
            'jenis_kelamin_pengguna' => $request->jenis_kelamin,
            'tanggal_lahir_pengguna' => $request->tanggal_lahir,
            'password' => bcrypt($request->password),
            'status_pengguna' => 'pending',
            'id_role' => $idRoleWarga,
        ]);

        $admins = Pengguna::whereHas('role.akses', function($q) {
            $q->where('nama_akses', 'kelola_pengguna');
        })->get();

        foreach ($admins as $admin) {
            if ($admin->email_pengguna) {
                try {
                    \Illuminate\Support\Facades\Mail::to($admin->email_pengguna)->send(new \App\Mail\PendaftaranBaruMail($user));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gagal mengirim email pendaftaran ke ' . $admin->email_pengguna . ': ' . $e->getMessage());
                }
            }
        }

        return redirect('/login')->with('success', 'Berhasil daftar, tunggu admin mengonfirmasi akun');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'reset_nomor_telepon' => 'required',
            'reset_tanggal_lahir' => 'required|date',
        ]);

        $user = Pengguna::where('nomor_telepon_pengguna', $request->reset_nomor_telepon)
                        ->where('tanggal_lahir_pengguna', $request->reset_tanggal_lahir)
                        ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Nomor telepon atau tanggal lahir tidak sesuai dengan data terdaftar.');
        }

        // Format tanggal lahir menjadi ddmmyyyy (dmY)
        $dob = \Carbon\Carbon::parse($user->tanggal_lahir_pengguna)->format('dmY');

        $user->password = bcrypt($dob);
        $user->save();

        return redirect('/login')->with('success', 'Password Anda berhasil diatur ulang menjadi tanggal lahir Anda (format: ddmmyyyy). Silakan login.');
    }
}