<!doctype html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <title>{{ $product->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite('resources/css/app.css') <!-- Tailwind CSS -->
</head>

<body class="bg-brand-peach/5 text-brand-dark font-sans">
    <div class="max-w-3xl mx-auto px-4 py-10">

        <!-- Link Indietro -->
        @php
            $previous = url()->previous();
            // Torna alla pagina precedente solo se è effettivamente lo shop
            $backUrl = str_contains($previous, '/shop') ? $previous : route('shop');
        @endphp

        <p class="mb-4">
            <a href="{{ $backUrl }}" class="text-brand-wine hover:underline flex items-center gap-1">
                <span class="text-lg">←</span> Indietro
            </a>
        </p>

        <!-- Titolo Prodotto -->
        <h1 class="text-3xl font-bold mb-4 text-brand-wine">{{ $product->name }}</h1>

        <!-- Immagine -->
        @php
            $image = null;

            if (is_array($product->images)) {
                $image = $product->images[0] ?? null;
            } elseif (is_string($product->images)) {
                $decoded = json_decode($product->images, true);
                $image = is_array($decoded) ? ($decoded[0] ?? null) : $product->images;
            }

            $imageExists = $image && file_exists(public_path('storage/' . $image));
        @endphp

        @if ($imageExists)
            <div class="w-full max-w-md aspect-square overflow-hidden rounded-xl shadow mb-6 bg-white mx-auto">
                <img src="{{ asset('storage/' . $image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover object-center">
            </div>
        @else
            <div class="w-full max-w-md aspect-square flex items-center justify-center bg-gray-300 rounded-xl mb-6 mx-auto">
                <span class="text-gray-500">Immagine non disponibile</span>
            </div>
        @endif

        <!-- Categoria -->
        @if ($product->category)
            <p class="text-brand-red mb-2">{{ $product->category->name }}</p>
        @endif

        <!-- Descrizione -->
        @if ($product->description)
            <p class="mb-4 text-brand-dark/80 whitespace-pre-line leading-relaxed">
                {{ $product->description }}
            </p>
        @endif

        <!-- Prezzo -->
        <p class="text-2xl font-semibold text-brand-red mb-4">
            {{ number_format($product->price_cents / 100, 2, ',', '.') }} €
        </p>

        <!-- Allergeni -->
        @if (!empty($product->allergens))
            <p class="text-brand-dark/60 mb-4">
                Allergeni: {{ implode(', ', $product->allergens) }}
            </p>
        @endif

        <!-- Form Carrello -->
        <form method="POST" action="{{ route('cart.add') }}" class="flex items-center gap-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="number" name="qty" value="1" min="1" max="20"
                class="w-20 px-3 py-2 border border-brand-dark/40 rounded-lg 
                       focus:outline-none focus:ring-2 focus:ring-brand-wine 
                       text-brand-dark bg-white">
            <button type="submit"
                class="px-5 py-2 rounded-lg bg-brand-wine text-white font-medium hover:bg-brand-red transition">
                Aggiungi al carrello
            </button>
        </form>

    </div>
</body>

</html>
