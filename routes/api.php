<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;

/*
|--------------------------------------------------------------------------
| API Routes (pubbliche, per il frontend Vue)
|--------------------------------------------------------------------------
*/

// Healthcheck
Route::get('/health', fn () => ['ok' => true, 'time' => now()->toISOString()]);

// Impostazioni negozio
Route::get('/store', function () {
    $s = StoreSetting::latest()->first();

    return [
        'store_name' => $s->store_name ?? 'Pasticceria Maitardi',
        'currency' => $s->currency ?? 'EUR',
        'shipping_base_cents' => (int) ($s->shipping_base_cents ?? 0),
        'free_shipping_threshold_cents' => (int) ($s->free_shipping_threshold_cents ?? 0),
        'is_open' => (bool) ($s->is_open ?? true),
        'updated_at' => optional($s)->updated_at?->toISOString(),
    ];
});

// Categorie visibili
Route::get('/categories', function () {
    return Category::where('is_visible', true)
        ->orderBy('name')
        ->get(['id','name','slug']);
});

// Dettaglio categoria
Route::get('/categories/{slug}', function (string $slug) {
    return Category::where('slug', $slug)
        ->where('is_visible', true)
        ->firstOrFail(['id','name','slug','description']);
});

// Prodotti di una categoria (paginati)
Route::get('/categories/{slug}/products', function (Request $request, string $slug) {
    $category = Category::where('slug', $slug)->where('is_visible', true)->firstOrFail();
    $perPage = (int) $request->integer('per_page', 9);

    $q = Product::whereHas('categories', fn($c) => $c->where('categories.id', $category->id))
        ->orderByDesc('id');

    $paginator = $q->paginate($perPage);

    $paginator->getCollection()->transform(fn($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'slug' => $p->slug,
        'price_cents' => $p->price_cents,
        'is_visible' => $p->is_visible,
        'categories' => $p->categories,
        'image_url' => $p->image_url,
        'image_urls' => $p->image_urls,
    ]);

    return response()->json([
        'data' => $paginator->items(),
        'meta' => [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
        ],
        'links' => [
            'next' => $paginator->nextPageUrl(),
            'prev' => $paginator->previousPageUrl(),
        ],
        'category' => [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
        ],
    ]);
});

// Listing prodotti con filtri e ricerca
Route::get('/products', function (Request $request) {
    $perPage = (int) $request->integer('per_page', 9);
    $categorySlug = $request->string('category')->toString() ?: null;
    $search = trim($request->string('q')->toString());
    $min = $request->has('min_price') ? max(0, (int) $request->integer('min_price')) : null;
    $max = $request->has('max_price') ? max(0, (int) $request->integer('max_price')) : null;

    $q = Product::orderByDesc('id');

    if ($categorySlug) {
        $q->whereHas('categories', fn($c) => $c->where('slug', $categorySlug));
    }

    if ($search !== '') {
        $q->where(function ($w) use ($search) {
            $w->where('name', 'like', "%{$search}%")
              ->orWhere('slug', 'like', "%{$search}%")
              ->orWhere('sku', 'like', "%{$search}%");
        });
    }

    if (!is_null($min)) $q->where('price_cents', '>=', $min);
    if (!is_null($max)) $q->where('price_cents', '<=', $max);

    $paginator = $q->paginate($perPage);

    $paginator->getCollection()->transform(fn($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'slug' => $p->slug,
        'price_cents' => $p->price_cents,
        'is_visible' => $p->is_visible,
        'categories' => $p->categories,
        // Gestione sicura immagini
        'image_url' => $p->image_url ?? 'https://picsum.photos/800/600?blur=2',
        'image_urls' => $p->image_urls ?? ['https://picsum.photos/800/600?blur=2'],
    ]);

    return response()->json([
        'data' => $paginator->items(),
        'meta' => [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
        ],
        'links' => [
            'next' => $paginator->nextPageUrl(),
            'prev' => $paginator->previousPageUrl(),
        ],
    ]);
});

// Dettaglio prodotto per slug
Route::get('/products/{slug}', function (string $slug) {
    $p = Product::where('slug', $slug)->firstOrFail();

    return [
        'id' => $p->id,
        'name' => $p->name,
        'slug' => $p->slug,
        'description' => $p->description,
        'price_cents' => $p->price_cents,
        'is_visible' => $p->is_visible,
        'stock' => $p->stock_qty,
        'categories' => $p->categories()->get(['id','name','slug']),
        'image_url' => $p->image_url ?? 'https://picsum.photos/800/600?blur=2',
        'image_urls' => $p->image_urls ?? ['https://picsum.photos/800/600?blur=2'],
    ];
});

// Prodotti in evidenza
Route::get('/featured-products', function () {
    $products = Product::orderByDesc('id')
        ->take(6)
        ->get();

    return $products->map(fn($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'slug' => $p->slug,
        'price_cents' => $p->price_cents,
        'is_visible' => $p->is_visible,
        'categories' => $p->categories,
        'image_url' => $p->image_url ?? 'https://picsum.photos/800/600?blur=2',
        'image_urls' => $p->image_urls ?? ['https://picsum.photos/800/600?blur=2'],
    ]);
});
