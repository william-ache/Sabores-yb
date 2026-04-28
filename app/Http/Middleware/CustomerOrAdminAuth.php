<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrAdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Si está autenticado por Auth (Google) o tiene la sesión de admin
        if (Auth::check() || $request->session()->get('admin_logged_in') || $request->session()->get('super_admin_logged_in')) {
            return $next($request);
        }

        return redirect()->route('admin.login');
    }
}
