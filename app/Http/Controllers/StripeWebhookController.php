<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        $secret = config('services.stripe.webhook_secret') ?? env('STRIPE_WEBHOOK_SECRET');
        if (! $secret) {
            Log::error('Stripe: webhook secret mancante (STRIPE_WEBHOOK_SECRET).');
            return response('Missing webhook secret', 500);
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret') ?? env('STRIPE_SECRET'));
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe: payload non valido', ['err' => $e->getMessage()]);
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Stripe: firma non valida', ['err' => $e->getMessage()]);
            return response('Invalid signature', 400);
        } catch (\Throwable $e) {
            Log::error('Stripe: errore generico in verifica webhook', ['err' => $e->getMessage()]);
            return response('Webhook error', 500);
        }

        $type   = $event->type;
        $object = $event->data->object;

        Log::info('Stripe: evento ricevuto', ['type' => $type]);

        if (in_array($type, ['payment_intent.succeeded', 'payment_intent.payment_failed'])) {
            $pi       = $object;
            $intentId = $pi->id ?? null;

            Log::info('Stripe: PI ricevuto', ['pi' => $intentId]);

            if ($intentId) {
                $order = Order::where('stripe_payment_intent', $intentId)->first();

                Log::info('Stripe: match ordine', [
                    'found' => (bool) $order,
                    'order_id' => $order?->id,
                    'code' => $order?->code,
                ]);

                if ($order) {
                    if ($type === 'payment_intent.succeeded') {
                        $order->update([
                            'payment_status' => 'paid',
                            'order_status'   => 'preparing',
                        ]);

                        // Decrementa stock dopo conferma pagamento
                        foreach ($order->items()->with('product')->get() as $orderItem) {
                            $product = $orderItem->product;
                            if ($product && !is_null($product->stock_qty)) {
                                $product->decrement('stock_qty', $orderItem->qty);
                            }
                        }

                        // Svuota il carrello associato
                        $cartId = $pi->metadata->cart_id ?? null;
                        if ($cartId) {
                            $cart = Cart::find($cartId);
                            if ($cart) {
                                $cart->items()->delete();
                            }
                        }

                        Log::info("Stripe: ordine {$order->code} aggiornato a paid/preparing, stock decrementato, carrello svuotato");
                    } else {
                        $order->update([
                            'payment_status' => 'failed',
                        ]);
                        Log::warning("Stripe: ordine {$order->code} aggiornato a failed");
                    }
                } else {
                    Log::warning('Stripe: nessun ordine trovato per PI', ['pi' => $intentId]);
                }
            }
        }

        if ($type === 'checkout.session.completed') {
            $intentId = $object->payment_intent ?? null;

            Log::info('Stripe: checkout.session.completed', ['pi' => $intentId]);

            if ($intentId) {
                $order = Order::where('stripe_payment_intent', $intentId)->first();

                if ($order) {
                    $order->update([
                        'order_status'   => Order::STATUS_PREPARING,
                        'payment_status' => Order::PAY_PAID,
                    ]);
                    Log::info("Stripe: ordine {$order->code} aggiornato da checkout.session a paid/preparing");
                } else {
                    Log::warning('Stripe: nessun ordine per checkout.session', ['pi' => $intentId]);
                }
            }
        }

        return response()->noContent();
    }
}
