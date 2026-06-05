<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilPadukuhan;
use App\Models\KontakPadukuhan;
use Illuminate\Support\Facades\Storage;

class ProfilPadukuhanController extends Controller
{
    public function index()
    {
        $profil = ProfilPadukuhan::first();
        $kontak = KontakPadukuhan::first();
        return view('informasi_umum.kelolaInformasiUmum', compact('profil', 'kontak'));
    }

    public function update(Request $request)
    {
        $profil = ProfilPadukuhan::first();

        $request->validate([
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'alamat_balai' => 'nullable|string',
            'nama_padukuhan' => 'nullable|string',
            'nama_kalurahan' => 'nullable|string',
            'nama_kecamatan' => 'nullable|string',
            'nama_kabupaten' => 'nullable|string',
            'sejarah' => 'nullable|string',
            'jam_operasional' => 'nullable|string',
            'foto_balai' => 'nullable|mimes:jpg,jpeg,png,heic,heif|max:10240',
            'foto_kebersamaan' => 'nullable|mimes:jpg,jpeg,png,heic,heif|max:10240',
            'link_maps_balai' => 'nullable|string',
            'logo_padukuhan' => 'nullable|mimes:jpg,jpeg,png,heic,heif|max:5120',
        ]);

        $data = $request->only([
            'visi', 'misi', 'alamat_balai', 'nama_padukuhan', 'nama_kalurahan',
            'nama_kecamatan', 'nama_kabupaten', 'sejarah', 'jam_operasional', 'link_maps_balai'
        ]);

        if ($request->hasFile('foto_balai')) {
            if ($profil && $profil->foto_balai) {
                Storage::disk('public')->delete(ltrim(str_replace('/storage', '', $profil->foto_balai), '/'));
            }
            $data['foto_balai'] = Storage::url($request->file('foto_balai')->store('profil_padukuhan', 'public'));
        }

        if ($request->hasFile('foto_kebersamaan')) {
            if ($profil && $profil->foto_kebersamaan) {
                Storage::disk('public')->delete(ltrim(str_replace('/storage', '', $profil->foto_kebersamaan), '/'));
            }
            $data['foto_kebersamaan'] = Storage::url($request->file('foto_kebersamaan')->store('profil_padukuhan', 'public'));
        }

        if ($request->hasFile('logo_padukuhan')) {
            if ($profil && $profil->logo_padukuhan) {
                Storage::disk('public')->delete(ltrim(str_replace('/storage', '', $profil->logo_padukuhan), '/'));
            }
            $data['logo_padukuhan'] = Storage::url($request->file('logo_padukuhan')->store('profil_padukuhan', 'public'));
        }

        if (!$profil) {
            ProfilPadukuhan::create($data);
        } else {
            $profil->update($data);
        }

        return back()->with('success', 'Profil Padukuhan berhasil diperbarui');
    }
}
