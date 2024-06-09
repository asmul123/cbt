<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('administrator.user', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'users' => User::all(),
            'roles' => Role::all()
        ]);
    }

    public function ubahpassword()
    {
        return view('akun', [
            'menu' => '',
            'smenu' => '',
        ]);
    }

    public function passwordupdate(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
        if ($currentPasswordStatus) {

            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'Kata Sandi Berhasil diganti');
        } else {
            return redirect()->back()->with('failed', 'Kata sandi saat ini salah');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);
        if ($validated['password'] !== $request->password_confirmation) {
            return redirect()->back()->with('failed', 'Konfirmasi Kata Sandi tidak sesuai');
        } else {
            User::create($validated);
            return redirect()->back()->with('success', 'User berhasil disimpan');
        }
    }

    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
