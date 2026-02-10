<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\StripeWebhookController;

// Root: gli admin vanno al pannello; tutti gli altri al catalogo pubblico
Route::get('/', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect('/admin');
    }
    return redirect()->route('catalogo');
});

// Catalogo pubblico
Route::get('/catalogo', function () {
    $categories = Category::where('is_visible', true)
        ->withCount('products')
        ->orderBy('name')
        ->get();

    $products = Product::where('is_visible', true)
        ->latest()
        ->take(12)
        ->get();

    return view('catalogo', compact('categories', 'products'));
})->name('catalogo');

// Pagina categoria
Route::get('/categorie/{category:slug}', function (Category $category) {
    $products = $category->products()
        ->where('is_visible', true)
        ->latest()
        ->paginate(12);

    return view('categoria', compact('category', 'products'));
})->name('categoria.show');

// Pagina prodotto
Route::get('/prodotti/{product:slug}', function (Product $product) {
    abort_unless($product->is_visible, 404);
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
Route::redirect('/dashboard', '/catalogo')->name('dashboard');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/create-order', [CheckoutController::class, 'createOrder'])->name('checkout.create');

// Webhook Stripe (invocabile)
Route::post('/stripe/webhook', StripeWebhookController::class)
    ->name('stripe.webhook');


// Thank you
Route::view('/checkout/thank-you', 'checkout.thank-you')->name('order.thankyou');

// Rotte di Breeze (login/registrazione)
require __DIR__ . '/auth.php';

Route::view('/home', 'home')->name('home');
Route::view('/chi-siamo', 'chi-siamo')->name('chi-siamo');

Route::get('/shop', function () {
    $categories = Category::where('is_visible', true)->orderBy('name')->get(['id','name','slug']);
    $products = Product::where('is_visible', true)->latest()->paginate(12);
    return view('shop', compact('categories','products'));
})->name('shop');

Route::view('/contatti', 'contatti')->name('contatti');
// Fallback 404 (evita errori brutti su URL inesistenti)
Route::fallback(function () {
    abort(404);
});
Route::view('/{any}', 'spa')->where('any', '.*');

Route::view('/', 'spa')->name('home');
Route::view('/home', 'spa');
Route::view('/chi-siamo', 'spa')->name('chi-siamo');
Route::view('/shop', 'spa')->name('shop');
Route::view('/contatti', 'spa')->name('contatti');
Route::redirect('/catalogo', '/shop')->name('catalogo');


Route::get('/debug-images', function () {
    $products = \App\Models\Product::all();

    $result = $products->map(function ($p) {
        return [
            'id' => $p->id,
            'name' => $p->name,
            'images_db' => $p->images,        // cosa è salvato nel DBåå
            'image_url' => $p->image_url,     // prima immagine
            'image_urls' => $p->image_urls,   // tutte le immagini
        ];
    });

    return response()->json($result);
});
