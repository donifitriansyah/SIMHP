<?php

namespace App\Http\Controllers;

use App\Models\ProfilInspektorat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilInspektoratController extends Controller
{
    /**
     * Tampilkan halaman profil inspektorat
     */
    public function index()
    {
        $profil = ProfilInspektorat::first();

        return view('pages.master-data.profil-inspektorat.index', compact('profil'));
    }

    /**
     * Simpan profil inspektorat
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:150',
            'alamat'    => 'required|string',
            'telepon'   => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:100',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {

            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')
                    ->store('profil-inspektorat', 'public');
            }

            ProfilInspektorat::create($validated);

            return redirect()
                ->route('profil-inspektorat.index')
                ->with('success', 'Profil Inspektorat berhasil ditambahkan.');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Profil Inspektorat gagal ditambahkan.');
        }
    }
    /**
     * Update profil
     */
    public function update(Request $request, ProfilInspektorat $profil_inspektorat)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:150',
            'alamat'    => 'required|string',
            'telepon'   => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:100',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {

            if ($request->hasFile('logo')) {

                if (
                    $profil_inspektorat->logo &&
                    Storage::disk('public')->exists($profil_inspektorat->logo)
                ) {
                    Storage::disk('public')->delete($profil_inspektorat->logo);
                }

                $validated['logo'] = $request->file('logo')
                    ->store('profil-inspektorat', 'public');
            }

            $profil_inspektorat->update($validated);

            return redirect()
                ->route('profil-inspektorat.index')
                ->with('success', 'Profil Inspektorat berhasil diperbarui.');
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Profil Inspektorat gagal diperbarui.');
        }
    }
}
