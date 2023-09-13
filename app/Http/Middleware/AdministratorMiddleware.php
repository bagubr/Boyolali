<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::guard('administrator')->user()){
            return redirect()->route('administrator')->with('error', 'Session telah habis');
        }
        if(!Auth::guard('administrator')->user()->is_active){
            return redirect()->route('administrator')->with('error', 'Login Gagal User Tidak Aktif');
        }
        return $next($request);
    }
}
