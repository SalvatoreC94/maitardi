<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background:#f8f8f8; font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f8f8; padding:32px 16px;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.05);">

          {{-- Header --}}
          <tr>
            <td style="background:#B4182D; padding:28px 32px; text-align:center;">
              <h1 style="margin:0; color:#fff; font-size:22px;">Nuovo Ordine Ricevuto!</h1>
            </td>
          </tr>

          {{-- Corpo --}}
          <tr>
            <td style="padding:32px;">
              <h2 style="color:#54162B; margin:0 0 16px; font-size:18px;">
                Ordine #{{ $order->code }}
              </h2>

              {{-- Info cliente --}}
              <div style="background:#fdf6f0; border-radius:10px; padding:16px; margin-bottom:20px;">
                <p style="margin:0 0 6px; font-weight:600; color:#54162B; font-size:14px;">Cliente</p>
                <p style="margin:0; font-size:14px; color:#37415C; line-height:1.6;">
                  <strong>{{ $order->customer_name }}</strong><br>
                  {{ $order->email }}<br>
                  @if ($order->phone)
                    Tel: {{ $order->phone }}<br>
                  @endif
                </p>
              </div>

              {{-- Indirizzo --}}
              @if ($order->delivery_address)
              <div style="background:#fdf6f0; border-radius:10px; padding:16px; margin-bottom:20px;">
                <p style="margin:0 0 6px; font-weight:600; color:#54162B; font-size:14px;">Spedire a</p>
                <p style="margin:0; font-size:14px; color:#37415C; line-height:1.6;">
                  {{ $order->delivery_address['via'] ?? '' }} {{ $order->delivery_address['civico'] ?? '' }}<br>
                  {{ $order->delivery_address['cap'] ?? '' }} {{ $order->delivery_address['citta'] ?? '' }} ({{ $order->delivery_address['prov'] ?? '' }})
                </p>
              </div>
              @endif

              {{-- Prodotti --}}
              <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:20px;">
                <tr style="background:#54162B;">
                  <td style="padding:10px 12px; color:#fff; font-weight:600; font-size:13px;">Prodotto</td>
                  <td style="padding:10px 12px; color:#fff; font-weight:600; font-size:13px; text-align:center;">Qtà</td>
                  <td style="padding:10px 12px; color:#fff; font-weight:600; font-size:13px; text-align:right;">Totale</td>
                </tr>
                @foreach ($order->items as $item)
                <tr>
                  <td style="padding:10px 12px; border-bottom:1px solid #f0f0f0; font-size:14px; color:#181A2F;">
                    {{ $item->product_name_snapshot ?? $item->product?->name ?? 'Prodotto' }}
                  </td>
                  <td style="padding:10px 12px; border-bottom:1px solid #f0f0f0; font-size:14px; text-align:center; color:#181A2F;">
                    {{ $item->qty }}
                  </td>
                  <td style="padding:10px 12px; border-bottom:1px solid #f0f0f0; font-size:14px; text-align:right; color:#181A2F;">
                    {{ number_format($item->total_cents / 100, 2, ',', '.') }} &euro;
                  </td>
                </tr>
                @endforeach
              </table>

              {{-- Totale --}}
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="padding:4px 0; font-size:14px; color:#37415C;">Subtotale</td>
                  <td style="padding:4px 0; font-size:14px; color:#37415C; text-align:right;">{{ number_format($order->subtotal_cents / 100, 2, ',', '.') }} &euro;</td>
                </tr>
                <tr>
                  <td style="padding:4px 0; font-size:14px; color:#37415C;">Spedizione</td>
                  <td style="padding:4px 0; font-size:14px; color:#37415C; text-align:right;">{{ number_format($order->delivery_fee_cents / 100, 2, ',', '.') }} &euro;</td>
                </tr>
                <tr>
                  <td style="padding:8px 0 0; font-size:18px; font-weight:700; color:#B4182D; border-top:2px solid #FDA481;">TOTALE</td>
                  <td style="padding:8px 0 0; font-size:18px; font-weight:700; color:#B4182D; text-align:right; border-top:2px solid #FDA481;">{{ number_format($order->total_cents / 100, 2, ',', '.') }} &euro;</td>
                </tr>
              </table>
            </td>
          </tr>

          {{-- Footer --}}
          <tr>
            <td style="background:#181A2F; padding:16px 32px; text-align:center;">
              <p style="margin:0; color:rgba(255,255,255,.6); font-size:12px;">
                Gestisci gli ordini dal <a href="{{ url('/admin') }}" style="color:#FDA481;">pannello admin</a>
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
