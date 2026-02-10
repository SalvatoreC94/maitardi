<nav class="bg-white shadow sticky top-0 z-50">
  <div class="mx-auto px-4 py-4 flex justify-between items-center">
    <a href="{{ route('catalogo') }}" class="text-2xl font-bold text-amber-600">
      Pasticceria Maitardi
    </a>
    <ul class="flex items-center gap-6">
      <li><a href="{{ route('catalogo') }}" class="hover:text-amber-600">Catalogo</a></li>
      <li><a href="{{ route('cart.show') }}" class="hover:text-amber-600">Carrello</a></li>
      <li><a href="{{ route('contatti') }}" class="hover:text-amber-600">Contatti</a></li>
    </ul>
  </div>
</nav>
