<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <title>Checkout - MaiTardi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <style>
    :root {
      --brand-wine: #54162B;
      --brand-red: #B4182D;
      --brand-peach: #FDA481;
      --brand-blue: #37415C;
      --brand-dark: #181A2F;
      --muted: #f8f8f8;
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

    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 32px;
      max-width: 1000px;
      margin: 0 auto;
    }

    @media (max-width: 800px) {
      .grid {
        display: flex;
        flex-direction: column-reverse;
        gap: 24px;
      }

      body { padding: 20px 12px; }
      h1 { font-size: 1.5rem; margin-bottom: 1.2rem; }
    }

    .card {
      border: 1px solid #eee;
      border-radius: 16px;
      background: #fff;
      padding: 24px 28px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
    }

    h3 {
      color: var(--brand-wine);
      font-size: 1.25rem;
      margin-bottom: 1rem;
    }

    label {
      display: block;
      margin: 10px 0 4px;
      font-weight: 500;
      color: var(--brand-blue);
    }

    input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      background: #fff;
      transition: border-color 0.2s;
    }

    input:focus {
      border-color: var(--brand-red);
      outline: none;
    }

    input:invalid:not(:placeholder-shown) {
      border-color: #b91c1c;
    }

    input:valid:not(:placeholder-shown) {
      border-color: #10b981;
    }

    button {
      padding: 12px 18px;
      border-radius: 10px;
      border: none;
      background: var(--brand-wine);
      color: #fff;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.25s;
      margin-top: 16px;
      width: 100%;
    }

    button:hover {
      background: var(--brand-red);
    }

    #error {
      color: #b91c1c;
      margin-top: 10px;
      min-height: 1.5em;
      font-size: 0.9rem;
      text-align: center;
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 0 0 1rem;
    }

    li {
      display: flex;
      justify-content: space-between;
      padding: 6px 0;
      border-bottom: 1px solid #f0f0f0;
      color: var(--brand-dark);
    }

    .line {
      display: flex;
      justify-content: space-between;
      margin: 8px 0;
      font-size: 0.95rem;
    }

    .total {
      font-weight: 700;
      font-size: 1.2rem;
      color: var(--brand-wine);
    }

    small {
      color: var(--brand-blue);
    }
  </style>

  <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
  <div style="max-width:1000px; margin:0 auto 16px;">
    <a href="{{ route('cart.show') }}" style="color:var(--brand-red); text-decoration:none; font-size:0.95rem; font-weight:500;">
      &larr; Torna al carrello
    </a>
  </div>

  <h1>Checkout</h1>

  <div class="grid">
    <!-- DATI SPEDIZIONE -->
    <div class="card">
      <h3>Dati di spedizione</h3>

      <form id="checkout-form" method="POST" action="{{ route('checkout.create') }}">
        @csrf

        <label>Nome e cognome *</label>
        <input 
          name="name" 
          type="text"
          value="{{ auth()->user()?->name ?? '' }}"
          required
          minlength="3"
          maxlength="100"
          placeholder="Mario Rossi"
          pattern="^[A-Za-zÀ-ÿ\s'-]+$"
          title="Solo lettere, spazi, apostrofi e trattini">

        <label>Email *</label>
        <input 
          name="email" 
          type="email" 
          value="{{ auth()->user()?->email ?? '' }}"
          required
          maxlength="100"
          placeholder="mario.rossi@esempio.it"
          pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
          title="Inserisci un'email valida">

        <label>Telefono</label>
        <input 
          name="phone" 
          type="tel" 
          value="{{ auth()->user()?->phone ?? '' }}"
          placeholder="+39 333 1234567"
          pattern="^(\+39)?[\s]?[0-9]{9,11}$"
          title="Numero di telefono italiano valido (es. 3331234567 o +39 333 1234567)">

        <label>Via *</label>
        <input 
          name="address[via]" 
          type="text"
          value="{{ auth()->user()?->shipping_address['via'] ?? '' }}" 
          required
          minlength="3"
          maxlength="100"
          placeholder="Via Roma">

        <label>Civico *</label>
        <input 
          name="address[civico]" 
          type="text"
          value="{{ auth()->user()?->shipping_address['civico'] ?? '' }}" 
          required
          maxlength="10"
          placeholder="12"
          pattern="^[0-9]+[A-Za-z]?$"
          title="Numero civico (es. 12, 12A, 12bis)">

        <label>CAP *</label>
        <input 
          name="address[cap]" 
          type="text"
          value="{{ auth()->user()?->shipping_address['cap'] ?? '' }}" 
          required
          pattern="^[0-9]{5}$"
          maxlength="5"
          placeholder="80100"
          title="CAP italiano a 5 cifre"
          inputmode="numeric">

        <label>Città *</label>
        <input 
          name="address[citta]" 
          type="text"
          value="{{ auth()->user()?->shipping_address['citta'] ?? '' }}" 
          required
          minlength="2"
          maxlength="50"
          placeholder="Napoli"
          pattern="^[A-Za-zÀ-ÿ\s'-]+$"
          title="Nome città valido">

        <label>Provincia *</label>
        <input 
          name="address[prov]" 
          type="text"
          value="{{ auth()->user()?->shipping_address['prov'] ?? '' }}" 
          required
          maxlength="2"
          minlength="2"
          placeholder="NA"
          pattern="^[A-Z]{2}$"
          title="Sigla provincia in maiuscolo (es. NA, RM, MI)"
          style="text-transform: uppercase;">

        <div id="payment-element" style="margin:16px 0;"></div>

        <button id="pay-btn" type="submit">Paga ora</button>
        <div id="error"></div>
      </form>
    </div>

    <!-- RIEPILOGO -->
    <div class="card">
      <h3>Riepilogo ordine</h3>
      <ul>
        @foreach ($items as $it)
          <li>
            {{ $it->product->name }} × {{ $it->qty }}
            <span>{{ number_format($it->total_cents / 100, 2, ',', '.') }} €</span>
          </li>
        @endforeach
      </ul>

      <div class="line">
        <span>Subtotale</span>
        <span>{{ number_format($subtotal / 100, 2, ',', '.') }} €</span>
      </div>

      <div class="line">
        <span>Spedizione
          @if ($subtotal >= (int) env('FREE_SHIPPING_THRESHOLD_CENTS', 6900))
            <small>(Gratis)</small>
          @else
            <small>(10,00 €)</small>
          @endif
        </span>
        <span>{{ number_format($shipping / 100, 2, ',', '.') }} €</span>
      </div>

      <div class="line total">
        <span>Totale</span>
        <span>{{ number_format($total / 100, 2, ',', '.') }} €</span>
      </div>
    </div>
  </div>

  <!-- STRIPE -->
  <script>
    (function() {
      const stripe = Stripe("{{ config('services.stripe.key', env('STRIPE_KEY')) }}");
      const form = document.getElementById('checkout-form');
      const payBtn = document.getElementById('pay-btn');
      const errorEl = document.getElementById('error');
      const returnUrl = "{{ url('/checkout/thank-you') }}";

      let elements = null;
      let clientSecret = null;
      let phase = 'init';

      // Auto-maiuscolo per provincia
      const provInput = document.querySelector('input[name="address[prov]"]');
      provInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.toUpperCase();
      });

      function setBusy(b) {
        payBtn.disabled = b;
        payBtn.style.opacity = b ? .6 : 1;
      }

      function fail(e) {
        console.error(e);
        errorEl.textContent = (e && e.message) ? e.message : String(e || 'Errore');
        setBusy(false);
      }

      payBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        errorEl.textContent = '';

        // Validazione HTML5
        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }

        try {
          if (phase === 'init') {
            setBusy(true);

            const body = new FormData(form);
            const res = await fetch(form.action, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
              },
              body
            });

            let data;
            try {
              data = await res.json();
            } catch {
              const text = await res.text();
              if (text && text.includes('Page Expired')) {
                throw new Error('Sessione scaduta (419). Ricarica e riprova.');
              }
              throw new Error('Errore server. Riprova tra poco.');
            }

            if (!res.ok || !data?.clientSecret) {
              const firstValidation = (data?.errors && Object.values(data.errors)[0]?.[0]) ||
                data?.message || data?.error || 'Errore in checkout.';
              throw new Error(firstValidation);
            }

            clientSecret = data.clientSecret;

            elements = stripe.elements({ clientSecret, locale: 'it' });
            const paymentElement = elements.create('payment', { wallets: { applePay: 'never' } });
            paymentElement.mount('#payment-element');

            phase = 'mounted';
            payBtn.textContent = 'Paga ora';
            setBusy(false);
            return;
          }

          if (phase === 'mounted') {
            setBusy(true);

            const { error: submitError } = await elements.submit();
            if (submitError) throw submitError;

            const { error } = await stripe.confirmPayment({
              elements,
              clientSecret,
              confirmParams: { return_url: returnUrl }
            });

            if (error) throw error;

            phase = 'confirming';
            setBusy(false);
            return;
          }
        } catch (err) {
          fail(err);
        }
      });
    })();
  </script>

</body>
</html>
