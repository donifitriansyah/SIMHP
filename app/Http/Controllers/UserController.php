<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('pages.master-data.manajemen-users.index', compact('users'));
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'username'  => 'required|string|max:50|unique:users,username',
            'email'     => 'nullable|email|max:100|unique:users,email',
            'password'  => 'required|min:6',
            'role'      => 'required|in:super_user,user_entry',
            'status'    => 'required|boolean',
        ]);

        try {

            User::create([
                'name'      => $validated['name'],
                'username'  => $validated['username'],
                'email'     => $validated['email'],
                'password'  => Hash::make($validated['password']),
                'role'      => $validated['role'],
                'status'    => $validated['status'],
            ]);

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal tambah user SIMHP: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'User gagal ditambahkan.');
        }
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:100',
            'username'  => 'required|string|max:50|unique:users,username,' . $user->id,
            'email'     => 'nullable|email|max:100|unique:users,email,' . $user->id,
            'password'  => 'nullable|min:6',
            'role'      => 'required|in:super_user,user_entry',
            'status'    => 'required|boolean',
        ]);

        try {

            $data = [
                'name'      => $validated['name'],
                'username'  => $validated['username'],
                'email'     => $validated['email'],
                'role'      => $validated['role'],
                'status'    => $validated['status'],
            ];

            if (!empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }

            $user->update($data);

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil diperbarui.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'User gagal diperbarui.');
        }
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        try {

            // Mencegah user menghapus akunnya sendiri
            if ($user->id == Auth::id()) {

                return back()
                    ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
            }

            $user->delete();

            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {



            return back()
                ->with('error', 'User gagal dihapus.');
        }
    }
}
