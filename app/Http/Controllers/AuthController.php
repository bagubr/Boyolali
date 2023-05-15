<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if($user){
            $check = Hash::check($request->password, $user->password);
            if($check){
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                    Auth::login($user);
                    return redirect()->route('home')->with('success', 'Login Berhasil');
                }else{
                    return redirect()->back()->with('error', 'Password yang anda masukan salah');
                }
            }else{
                return redirect()->back()->with('error', 'Password yang anda masukan salah');
            }
        }else{
            return redirect()->back()->with('error', 'Username yang anda masukan tidak terdaftar');
        }
    }

    public function registration(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validate([
                'name'=> 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed'
            ]);
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            event(new Registered($user));
            // DO IT Sand Email
            DB::commit();
            return redirect()->route('users')->with('success', 'Registrasi Berhasil silahkan konfirmasi email anda!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('users')->with('error', 'Registrasi Gagal silahkan coba kembali!');
        }
        
        
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('users')->with('success', 'Logout Berhasil');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('email', $user->email)->first();
            
            if($finduser){
                auth()->login($finduser, true);
                return redirect()->route('home')->with('success', 'Login Berhasil');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => Hash::make($user->id)
                ]);
                auth()->login($newUser, true);
                return redirect()->route('home')->with('success', 'Login Berhasil');
            }
      
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan Coba Ulangi Kembali');
        }
    }
}
