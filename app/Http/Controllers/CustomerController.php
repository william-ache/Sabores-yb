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
            return redirect()->route('admin.login');
        }

        // Mock data for now since we don't have orders linked to users yet
        $orders = []; 

        return view('customer.dashboard', compact('user', 'orders'));
    }

    public function profile()
    {
        return view('customer.profile', ['user' => Auth::user()]);
    }

    public function payments()
    {
        return view('customer.payments');
    }
}
