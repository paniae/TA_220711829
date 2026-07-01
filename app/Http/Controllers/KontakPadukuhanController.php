<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontakPadukuhan;

class KontakPadukuhanController extends Controller
{
    public function update(Request $request)
    {
        $kontak = KontakPadukuhan::first();
        
        $request->validate([
            'nomor_telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'instagram' => 'nullable|string',
            'status_kontak' => 'nullable|string'
        ]);

        $data = $request->only(['nomor_telepon', 'email', 'instagram', 'status_kontak']);

        if (!$kontak) {
            KontakPadukuhan::create($data);
        } else {
            $kontak->update($data);
        }

        return back()->with('success', 'Kontak Padukuhan berhasil diperbarui');
    }
}
