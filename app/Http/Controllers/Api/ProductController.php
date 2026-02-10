<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Lista dei prodotti visibili, eventualmente filtrati per categoria
     */
    public function index(Request $request)
    {
        $query = Product::query()
            ->where('is_visible', true)
            ->with(['categories:id,name,slug']);

        // Filtro per categoria via slug
        if ($slug = $request->query('category')) {
            $category = Category::where('slug', $slug)
                ->where('is_visible', true)
                ->first();

            if ($category) {
                $query->whereHas('categories', fn ($q) => $q->where('categories.id', $category->id));
            } else {
                return response()->json([
                    'data' => [],
                    'meta' => ['current_page' => 1, 'last_page' => 1, 'total' => 0],
                ]);
            }
        }

        $products = $query->orderByDesc('id')->paginate(12);

        // Campi principali + accessors immagini
        $products->getCollection()->transform(function ($p) {
            return [
                'id'          => $p->id,
                'name'        => $p->name,
                'slug'        => $p->slug,
                'price_cents' => $p->price_cents,
                'stock'       => $p->stock_qty,
                'categories'  => $p->categories,
                'image_url'   => $p->image_url,
                'image_urls'  => $p->image_urls,
            ];
        });

        return response()->json($products);
    }

    /**
     * Mostra un singolo prodotto per slug
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_visible', true)
            ->with(['categories:id,name,slug'])
            ->firstOrFail();

        // versione raw (con \n), e versione HTML-safe con <br> (escape prima, nl2br dopo)
        $descriptionRaw  = $product->description ?? '';
        $descriptionHtml = nl2br(e($descriptionRaw));

        return response()->json([
            'id'               => $product->id,
            'name'             => $product->name,
            'slug'             => $product->slug,
            'description'      => $descriptionRaw,   // mantiene \n
            'description_html' => $descriptionHtml, // già pronta con <br>, safe
            'price_cents'      => $product->price_cents,
            'stock'            => $product->stock_qty,
            'categories'       => $product->categories,
            'image_url'        => $product->image_url,
            'image_urls'       => $product->image_urls,
        ]);
    }

    /**
     * Restituisce solo prodotti in evidenza
     */
    public function featured()
    {
        $products = Product::where('is_visible', true)
            ->orderByDesc('id')
            ->take(6)
            ->get();

        return response()->json($products->map(function ($p) {
            return [
                'id'          => $p->id,
                'name'        => $p->name,
                'slug'        => $p->slug,
                'price_cents' => $p->price_cents,
                'categories'  => $p->categories,
                'image_url'   => $p->image_url,
                'image_urls'  => $p->image_urls,
            ];
        }));
    }
}
