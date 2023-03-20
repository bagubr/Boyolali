<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAgendaMiddleware
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
        if(!Auth::guard('agenda')->user()){
            return redirect()->route('agenda')->with('error', 'Session telah habis');
        }
        if(!Auth::guard('agenda')->user()->is_active){
            return redirect()->route('agenda')->with('error', 'Login Gagal User Tidak Aktif');
        }
        return $next($request);
    }
}
