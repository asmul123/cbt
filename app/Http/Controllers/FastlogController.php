<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FastlogController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return redirect()->back()->with('failed', 'Nama Penguna atau Kata sandi salah');
    }

    public function pengawas(Request $request)
    {
        if($request->key == "1QaPcRrAvXP1Rxe9J.LJFqMVhn5kRQOVp3eYc91jKIZa4HZlK"){
            return view('pengawas.fastlog', [
                'no' => 1,
                'ruangans' => Ruangan::all()
            ]);
        } else {
            return redirect()->intended('/');
        }
    }
}
