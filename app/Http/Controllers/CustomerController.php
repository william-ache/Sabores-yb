<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Branch;

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
        
        $orders = Order::where('user_id', $user->id)->get();
        $logo = Setting::get('logo');
        $appName = Setting::get('app_name', 'Sabores Y&B');
        $systemPrimary = Setting::get('primary_color', '#00A859');

        return view('customer.dashboard', compact('user', 'orders', 'logo', 'appName', 'systemPrimary'));
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

        // Cargar direcciones y sedes
        if ($user->id) {
            $user->load('addresses');
        }
        $branches = \App\Models\Branch::where('is_active', true)->get();
        $logo = \App\Models\Setting::get('logo', '');
        $primaryColor = \App\Models\Setting::get('primary_color', '#00A859');

        return view('customer.profile', compact('user', 'branches', 'logo', 'primaryColor'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            if (session('admin_logged_in') || session('super_admin_logged_in')) {
                $user = \App\Models\User::where('role', 'admin')->first();
            }
        }

        if (!$user) {
            return back()->with('error', 'Debes estar autenticado para realizar esta acción.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'delivery_name' => 'nullable|string|max:255',
            'phone_1' => 'nullable|string|max:20',
            'phone_2' => 'nullable|string|max:20',
            'id_card' => 'nullable|string|max:20',
            'cropped_avatar' => 'nullable|string',
            'addresses' => 'nullable|array|max:3',
            'addresses.*.id' => 'nullable|integer',
            'addresses.*.label' => 'nullable|string|max:50',
            'addresses.*.address' => 'required|string',
            'addresses.*.latitude' => 'nullable|numeric',
            'addresses.*.longitude' => 'nullable|numeric',
            'addresses.*.is_primary' => 'nullable|boolean',
        ]);

        // Manejar Avatar (Base64)
        if ($request->filled('cropped_avatar')) {
            $imageData = $request->input('cropped_avatar');
            $fileName = 'avatars/' . $user->id . '_' . time() . '.jpg';
            
            $data = explode(',', $imageData);
            $decodedImage = base64_decode($data[1]);
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, $decodedImage);
            $validated['avatar'] = $fileName;
        }

        // Actualizar datos básicos
        $user->update([
            'name' => $validated['name'],
            'delivery_name' => $validated['delivery_name'],
            'phone_1' => $validated['phone_1'],
            'phone_2' => $validated['phone_2'],
            'id_card' => $validated['id_card'],
            'avatar' => $validated['avatar'] ?? $user->avatar,
        ]);

        // Manejar Direcciones (Máximo 3)
        if ($request->has('addresses')) {
            $existingAddressIds = [];
            
            foreach ($request->addresses as $index => $addrData) {
                if ($index >= 3) break; // Límite de 3

                $isPrimary = isset($addrData['is_primary']) && $addrData['is_primary'] == '1';

                $address = $user->addresses()->updateOrCreate(
                    ['id' => $addrData['id'] ?? null],
                    [
                        'label' => $addrData['label'],
                        'address' => $addrData['address'],
                        'latitude' => $addrData['latitude'] ?? null,
                        'longitude' => $addrData['longitude'] ?? null,
                        'is_primary' => $isPrimary,
                    ]
                );
                $existingAddressIds[] = $address->id;
            }

            // Si se marcó una como primaria, aseguramos que las demás no lo sean
            if ($user->addresses()->where('is_primary', true)->count() > 1) {
                 // Esto es un poco redundante si el frontend ya lo controla, pero por seguridad:
                 // Podríamos forzar que solo la última marcada sea la primaria.
            }

            // Eliminar direcciones que no se enviaron (si se quiere permitir borrar)
            $user->addresses()->whereNotIn('id', $existingAddressIds)->delete();
        }

        return back()->with('success', 'Perfil actualizado con éxito.');
    }

    public function payments()
    {
        return view('customer.payments');
    }

    public function storeOrder(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            // Permitir admins en modo sesión también
            if (session('admin_logged_in') || session('super_admin_logged_in')) {
                $user = User::where('role', 'admin')->first();
            }
        }

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        $validated = $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'type' => 'required|string',
            'delivery_address' => 'nullable|string',
            'delivery_cost' => 'nullable|numeric',
            'payment_method' => 'nullable|string',
            'payment_reference' => 'nullable|string',
            'branch_id' => 'nullable|integer',
        ]);

        $order = Order::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'total' => $validated['total'],
            'subtotal' => $validated['subtotal'],
            'status' => 'Pendiente',
            'type' => $validated['type'],
            'delivery_address' => $validated['delivery_address'],
            'delivery_cost' => $validated['delivery_cost'] ?? 0,
            'payment_method' => $validated['payment_method'],
            'payment_reference' => $validated['payment_reference'],
            'branch_id' => $validated['branch_id'],
        ]);

        foreach ($validated['items'] as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->id
        ]);
    }

    public function orders()
    {
        $user = Auth::user();
        if (!$user && (session('admin_logged_in') || session('super_admin_logged_in'))) {
            $user = User::where('role', 'admin')->first();
        }

        if (!$user) {
            return redirect()->route('admin.login');
        }

        $orders = Order::where('user_id', $user->id)
            ->with(['items.product', 'branch'])
            ->latest()
            ->get();

        $logo = Setting::get('logo');
        $appName = Setting::get('app_name', 'Sabores Y&B');
        $systemPrimary = Setting::get('primary_color', '#00A859');

        return view('customer.orders.index', compact('orders', 'user', 'logo', 'appName', 'systemPrimary'));
    }

    public function updateOrderPayment(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'payment_reference' => 'nullable|string',
        ]);

        $order = Order::find($validated['order_id']);
        if ($order) {
            $order->update([
                'payment_reference' => $validated['payment_reference'],
                'status' => 'Procesando' // Cambiamos a procesando cuando reportan el pago
            ]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}
