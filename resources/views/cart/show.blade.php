<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <title>Carrello - MaiTardi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    :root {
      --brand-wine: #54162B;
      --brand-red: #B4182D;
      --brand-peach: #FDA481;
      --brand-blue: #37415C;
      --brand-dark: #181A2F;
    }

    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, sans-serif;
      background: #fff;
      color: var(--brand-dark);
      margin: 0;
      padding: 40px 20px;
    }

    h1 {
      text-align: center;
      font-size: 2rem;
      color: var(--brand-wine);
      margin-bottom: 2rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
    }

    th {
      background: var(--brand-wine);
      color: #fff;
      text-align: left;
      padding: 14px 16px;
      font-weight: 600;
    }

    td {
      padding: 14px 16px;
      border-bottom: 1px solid #f0f0f0;
      vertical-align: middle;
    }

    tr:last-child td {
      border-bottom: none;
    }

    input[type="number"] {
      width: 60px;
      padding: 6px 8px;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      text-align: center;
      font-size: 1rem;
    }

    .btn {
      display: inline-block;
      padding: 8px 14px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.95rem;
      text-decoration: none;
      transition: background 0.2s, color 0.2s;
      cursor: pointer;
    }

    .btn-light {
      border: 1px solid var(--brand-red);
      color: var(--brand-red);
      background: #fff;
    }

    .btn-light:hover {
      background: var(--brand-peach);
      color: var(--brand-dark);
      border-color: var(--brand-peach);
    }

    .btn-dark {
      background: var(--brand-wine);
      color: #fff;
      border: 1px solid var(--brand-wine);
    }

    .btn-dark:hover {
      background: var(--brand-red);
      border-color: var(--brand-red);
    }

    .total {
      font-size: 1.2rem;
      font-weight: 700;
      text-align: right;
      margin-top: 1.5rem;
      color: var(--brand-wine);
    }

    .actions {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .cart-footer {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 10px;
      margin-top: 20px;
    }

    .empty-cart {
      text-align: center;
      font-size: 1.1rem;
      color: var(--brand-blue);
      margin-top: 2rem;
    }

    /* --- Sezione suggerimenti --- */
    .suggestions {
      margin-top: 4rem;
      padding-top: 2rem;
      border-top: 2px solid #f3f4f6;
      text-align: center;
    }

    .suggestions h2 {
      color: var(--brand-wine);
      font-size: 1.8rem;
      margin-bottom: 1.5rem;
    }

    .suggestion-grid {
      display: grid;
      gap: 1.5rem;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      max-width: 1000px;
      margin: 0 auto;
    }

    .suggestion-item {
      border: 1px solid #f0f0f0;
      border-radius: 14px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .suggestion-item:hover {
      transform: translateY(-4px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .suggestion-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .suggestion-item h3 {
      color: var(--brand-dark);
      font-size: 1.1rem;
      margin: 12px;
    }

    .suggestion-item p {
      color: var(--brand-red);
      font-weight: 600;
      margin: 0 12px 12px;
    }
  </style>
</head>

<body>
  <h1>Il tuo carrello</h1>

  @if (session('ok'))
    <p style="color:green; text-align:center">{{ session('ok') }}</p>
  @endif

  @if ($errors->any())
    <p style="color:#b91c1c; text-align:center">{{ $errors->first() }}</p>
  @endif

  @if ($items->isEmpty())
    <p class="empty-cart">Il tuo carrello è vuoto.</p>
    <div style="text-align:center; margin-top:20px">
      <a href="{{ route('shop') }}" class="btn btn-dark">Continua lo shopping</a>
    </div>
  @else
    <table>
      <thead>
        <tr>
          <th>Prodotto</th>
          <th>Prezzo</th>
          <th>Qtà</th>
          <th>Totale</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($items as $it)
          <tr>
            <td>{{ $it->product->name }}</td>
            <td>{{ number_format($it->unit_price_cents / 100, 2, ',', '.') }} €</td>
            <td>
              <form method="POST" action="{{ route('cart.update', $it) }}" class="cart-qty-form">
                @csrf @method('PATCH')
                <input type="number" name="qty" value="{{ $it->qty }}" min="1" max="20" onchange="this.form.submit()">
                <noscript><button class="btn btn-light" type="submit">Aggiorna</button></noscript>
              </form>
            </td>
            <td>{{ number_format($it->total_cents / 100, 2, ',', '.') }} €</td>
            <td class="actions">
              <form method="POST" action="{{ route('cart.remove', $it) }}">
                @csrf @method('DELETE')
                <button class="btn btn-light" type="submit">Rimuovi</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <p class="total">Subtotale: {{ number_format($subtotal / 100, 2, ',', '.') }} €</p>

    <div class="cart-footer">
      <a href="{{ route('shop') }}" class="btn btn-light">Continua lo shopping</a>
      <a href="{{ route('checkout.show') }}" class="btn btn-dark">Vai al checkout</a>
    </div>

    @if ($suggested->count() > 0)
      <div class="suggestions">
        <h2>Potrebbe piacerti anche</h2>
        <div class="suggestion-grid">
          @foreach ($suggested as $product)
            <div class="suggestion-item">
              <a href="{{ route('shop') }}" style="text-decoration:none; color:inherit;">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>€ {{ number_format($product->price_cents / 100, 2, ',', '.') }}</p>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  @endif
</body>
</html>
