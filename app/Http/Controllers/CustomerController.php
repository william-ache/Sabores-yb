<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = \App\Models\User::where('role', 'customer')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        if (!$user) {
            if (session('admin_logged_in') || session('super_admin_logged_in')) {
                // Buscamos el primer admin en DB o creamos uno ficticio para la vista
                $user = \App\Models\User::where('role', 'admin')->first() ?? new \App\Models\User([
                    'name' => 'Administrador de Sistema',
                    'email' => 'admin@' . request()->getHost(),
                    'role' => 'admin'
                ]);
            } else {
                return redirect()->route('admin.login');
            }
        }
        
        // Mock data for now since we don't have orders linked to users yet
        $orders = []; 

        return view('customer.dashboard', compact('user', 'orders'));
    }

    public function profile()
    {
        $user = Auth::user();
        if (!$user) {
            if (session('admin_logged_in') || session('super_admin_logged_in')) {
                $user = \App\Models\User::where('role', 'admin')->first() ?? new \App\Models\User([
                    'name' => 'Administrador de Sistema',
                    'email' => 'admin@' . request()->getHost(),
                    'role' => 'admin'
                ]);
            } else {
                return redirect()->route('admin.login');
            }
        }

        return view('customer.profile', compact('user'));
    }

    public function payments()
    {
        return view('customer.payments');
    }
}
