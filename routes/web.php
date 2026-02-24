<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeWebhookController;

// Root: gli admin vanno al pannello; tutti gli altri allo shop
Route::get('/', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect('/admin');
    }
    return redirect()->route('shop');
});

// Pagina prodotto (Blade, resta separata dalla SPA)
Route::get('/prodotti/{product:slug}', function (Product $product) {
    return view('prodotto', compact('product'));
})->name('prodotto.show');

// Carrello
Route::prefix('carrello')->group(function () {
    Route::post('/aggiungi', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/aggiorna/{item}', [CartController::class, 'update'])
        ->whereNumber('item')
        ->name('cart.update');
    Route::delete('/rimuovi/{item}', [CartController::class, 'remove'])
        ->whereNumber('item')
        ->name('cart.remove');
    Route::get('/', [CartController::class, 'show'])->name('cart.show');
});

// Fix: alias per route 'dashboard' (usata da Breeze)
Route::redirect('/dashboard', '/shop')->name('dashboard');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/create-order', [CheckoutController::class, 'createOrder'])->name('checkout.create');

// Webhook Stripe
Route::post('/stripe/webhook', StripeWebhookController::class)
    ->name('stripe.webhook');

// Thank you
Route::view('/checkout/thank-you', 'checkout.thank-you')->name('order.thankyou');

// Rotte di Breeze (login/registrazione)
require __DIR__ . '/auth.php';

// Pagine SPA (Vue) — route con nomi per generare URL con route()
Route::view('/home', 'spa')->name('home');
Route::view('/chi-siamo', 'spa')->name('chi-siamo');
Route::view('/shop', 'spa')->name('shop');
Route::view('/contatti', 'spa')->name('contatti');
Route::redirect('/catalogo', '/shop')->name('catalogo');

// Catch-all SPA per tutte le route non definite sopra
Route::view('/{any}', 'spa')->where('any', '.*');
