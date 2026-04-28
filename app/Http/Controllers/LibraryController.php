<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public static function getIcons()
    {
        return [
            'Comida y Bebidas' => [
                'fas fa-burger', 'fas fa-pizza-slice', 'fas fa-hotdog', 'fas fa-cheese', 'fas fa-egg', 
                'fas fa-bacon', 'fas fa-bone', 'fas fa-drumstick-bite', 'fas fa-ice-cream', 'fas fa-cookie', 
                'fas fa-candy-cane', 'fas fa-bread-slice', 'fas fa-apple-whole', 'fas fa-carrot', 
                'fas fa-pepper-hot', 'fas fa-seedling', 'fas fa-bowl-food', 'fas fa-utensils', 
                'fas fa-mug-hot', 'fas fa-mug-saucer', 'fas fa-glass-water', 'fas fa-champagne-glasses',
                'fas fa-wine-glass', 'fas fa-beer-mug-empty', 'fas fa-martini-glass-cocktail'
            ],
            'Comercio y Tienda' => [
                'fas fa-cart-shopping', 'fas fa-basket-shopping', 'fas fa-store', 'fas fa-shop', 'fas fa-bag-shopping',
                'fas fa-tag', 'fas fa-tags', 'fas fa-ticket', 'fas fa-credit-card', 'fas fa-wallet',
                'fas fa-money-bill-1-wave', 'fas fa-cash-register', 'fas fa-truck', 'fas fa-truck-fast', 'fas fa-box',
                'fas fa-boxes-stacked', 'fas fa-gift'
            ],
            'Interfaz y Navegación' => [
                'fas fa-house', 'fas fa-user', 'fas fa-users', 'fas fa-gear', 'fas fa-gears',
                'fas fa-magnifying-glass', 'fas fa-bell', 'fas fa-envelope', 'fas fa-calendar-days', 'fas fa-star',
                'fas fa-heart', 'fas fa-thumbs-up', 'fas fa-circle-check', 'fas fa-triangle-exclamation',
                'fas fa-circle-info', 'fas fa-circle-question', 'fas fa-trash-can', 'fas fa-pen-to-square',
                'fas fa-plus', 'fas fa-minus', 'fas fa-arrow-right', 'fas fa-arrow-left', 'fas fa-chevron-right',
                'fas fa-chevron-left', 'fas fa-bars', 'fas fa-xmark', 'fas fa-eye', 'fas fa-eye-slash'
            ],
            'Ubicación y Tiempo' => [
                'fas fa-location-dot', 'fas fa-map-pin', 'fas fa-compass', 'fas fa-earth-americas', 'fas fa-clock',
                'fas fa-hourglass-half', 'fas fa-stopwatch'
            ],
            'Herramientas y Otros' => [
                'fas fa-hammer', 'fas fa-wrench', 'fas fa-screwdriver-wrench', 'fas fa-palette', 'fas fa-brush',
                'fas fa-camera', 'fas fa-video', 'fas fa-microphone', 'fas fa-mobile-screen-button', 'fas fa-laptop'
            ]
        ];
    }

    public function icons()
    {
        $icons = self::getIcons();
        return view('admin.library.icons', compact('icons'));
    }
}
