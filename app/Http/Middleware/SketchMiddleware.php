<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SketchMiddleware
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
        if(!Auth::guard('sketch')->user()){
            return redirect()->route('sketch')->with('error', 'Session telah habis');
        }
        if(!Auth::guard('sketch')->user()->is_active){
            return redirect()->route('sketch')->with('error', 'Login Gagal User Tidak Aktif');
        }
        return $next($request);
    }
}
