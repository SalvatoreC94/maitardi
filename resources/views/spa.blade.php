<!doctype html>
<html lang="it">
<head>
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  integrity="sha512-u94pR3gfd2BzhXW9G1ozZNf8dZh+jZMq+8IYk2aVsuWQHNFEkYVGfhyApvP7SqPu8iAuJsuMZ6I0r3wqJHb4UQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pasticceria Maitardi - Panettoni e dolci artigianali</title>
    <meta name="description" content="Scopri i panettoni e dolci artigianali di Pasticceria Maitardi. Prodotti unici realizzati a mano con ingredienti selezionati. Ordina online in tutta Italia.">
    <meta name="keywords" content="pasticceria artigianale, panettone artigianale, colomba artigianale, dolci tradizionali, Pasticceria Maitardi">
    <meta name="author" content="Pasticceria Maitardi">

    <!-- SOCIAL SHARE -->
    <meta property="og:title" content="Pasticceria Maitardi - Dolci Artigianali">
    <meta property="og:description" content="Panettoni, colombe e dolci artigianali realizzati a mano con amore.">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:url" content="https://www.maitardishop.it">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <!-- SCHEMA.ORG JSON-LD -->
    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Bakery",
        "name": "Pasticceria Maitardi",
        "image": "https://www.maitardishop.it/images/og-image.jpg",
        "url": "https://www.maitardishop.it",
        "telephone": "+39 3348169141",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Via Giovanni Amendola, 5",
            "addressLocality": "San Valentino Torio",
            "addressRegion": "SA",
            "postalCode": "84010",
            "addressCountry": "IT"
        },
        "sameAs": [
            "https://www.instagram.com/maitardiloungebar",
            "https://www.facebook.com/ProdottiSicilianiMaiTardi"
        ]
    }
    </script>
    @endverbatim

    {{-- Carica la build Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-stone-50 text-stone-900">
    <div id="app"></div>

    {{-- Iubenda Termini e Condizioni --}}
    <script defer src="https://embeds.iubenda.com/widgets/3c9c63e6-abe7-459a-bd33-69be500695c2.js"></script>
</body>
</html>
