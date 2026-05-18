<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Models\Product;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Rutas de Cliente (Login con Google)
Route::group(['prefix' => 'mi-cuenta', 'middleware' => 'customer.or.admin'], function() {
    Route::get('/', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/perfil', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::post('/perfil', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('/save-order', [CustomerController::class, 'storeOrder'])->name('customer.order.store');
    Route::post('/update-order-payment', [CustomerController::class, 'updateOrderPayment'])->name('customer.order.update_payment');
    Route::get('/ordenes', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/pagos', [CustomerController::class, 'payments'])->name('customer.payments');
    Route::post('/logout', function() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('customer.logout');
});

Route::get('/', function () {
    $categories = \App\Models\Category::where('is_active', true)
        ->orderBy('sort_order', 'asc')
        ->with(['products' => function($q) {
            $q->where('is_active', true);
        }])
        ->get();
    
    $branches = \App\Models\Branch::where('is_active', true)->get();
    
    return view('welcome', compact('categories', 'branches'));
});

Route::get('/pedido/ver/{order}', [CustomerController::class, 'showPublicOrder'])->name('order.public_show');

Route::get('/politicas-de-uso', function () {
    return view('policies');
})->name('policies');

// Alias para el login por defecto de Laravel
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.index');
        Route::get('icons', [\App\Http\Controllers\LibraryController::class, 'icons'])->name('admin.icons');
        Route::get('products', [AdminController::class, 'index'])->name('admin.products.index');
        Route::get('create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('{product}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('{product}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('{product}', [AdminController::class, 'destroy'])->name('admin.destroy');

        Route::get('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
        Route::post('categories/reorder', [CategoryController::class, 'updateOrder'])->name('categories.updateOrder');
        Route::resource('categories', CategoryController::class);
        Route::resource('users', UserController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('customers', \App\Http\Controllers\CustomerController::class);
        Route::resource('inventories', InventoryController::class);

        // Módulos Dinámicos
        Route::get('modules/{moduleName}', [\App\Http\Controllers\DynamicModuleController::class, 'index'])->name('admin.modules.index');
        Route::get('modules/{moduleName}/create', [\App\Http\Controllers\DynamicModuleController::class, 'create'])->name('admin.modules.create');
        Route::post('modules/{moduleName}', [\App\Http\Controllers\DynamicModuleController::class, 'store'])->name('admin.modules.store');
        Route::get('modules/{moduleName}/{id}/edit', [\App\Http\Controllers\DynamicModuleController::class, 'edit'])->name('admin.modules.edit');
        Route::put('modules/{moduleName}/{id}', [\App\Http\Controllers\DynamicModuleController::class, 'update'])->name('admin.modules.update');
        Route::delete('modules/{moduleName}/{id}', [\App\Http\Controllers\DynamicModuleController::class, 'destroy'])->name('admin.modules.destroy');
    });
});

