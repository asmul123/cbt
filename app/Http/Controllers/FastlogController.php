<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\User;
use App\Models\Server;
use App\Models\Anggotakelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FastlogController extends Controller
{
    public function authenticate(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if($user->role_id == 3){
            $kelompok = Anggotakelompok::where('user_id',$user->id)->first();
            $server_id = $kelompok->kelompok->ruangan->server_id;
            $linkserver = Server::where('id', $server_id)->first()->linkserver;
            if($server_id != 1){
                return redirect($linkserver.'/fastlog?username='.$request->username.'&password='.$request->password);
            } else {
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
        } else {
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
