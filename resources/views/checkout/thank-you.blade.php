<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ordine confermato - MaiTardi</title>

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
      padding: 60px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      min-height: 100vh;
    }

    h1 {
      color: var(--brand-wine);
      font-size: 2.2rem;
      margin-bottom: 1rem;
    }

    p {
      font-size: 1.1rem;
      color: var(--brand-blue);
      margin-bottom: 1rem;
      max-width: 600px;
      line-height: 1.6;
    }

    a {
      display: inline-block;
      margin-top: 1.5rem;
      padding: 10px 18px;
      border-radius: 10px;
      background: var(--brand-wine);
      color: #fff;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.25s;
    }

    a:hover {
      background: var(--brand-red);
    }

    .icon {
      width: 90px;
      height: 90px;
      background: var(--brand-peach);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .icon svg {
      width: 40px;
      height: 40px;
      fill: var(--brand-wine);
    }

    footer {
      margin-top: 3rem;
      font-size: 0.9rem;
      color: #999;
    }
  </style>
</head>

<body>
  <div class="icon">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
      <path
        d="M12 0a12 12 0 1012 12A12.014 12.014 0 0012 0zm0 22a10 10 0 1110-10 10.011 10.011 0 01-10 10zm5-13.59l-5.7 5.7-2.3-2.3a1 1 0 00-1.4 1.42l3 3a1 1 0 001.4 0l6.4-6.4a1 1 0 10-1.4-1.42z" />
    </svg>
  </div>

  <h1>Grazie! Ordine ricevuto 🎉</h1>

  <p>
    Se il pagamento è andato a buon fine, il tuo ordine è già in preparazione nei nostri laboratori.
  </p>

  <a href="{{ route('catalogo') }}">Torna al catalogo</a>

  <footer>
    <p>🍰 Pasticceria MaiTardi — Tradizione e passione artigianale</p>
  </footer>
</body>

</html>
