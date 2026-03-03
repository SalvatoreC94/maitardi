<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Spedizione
    |--------------------------------------------------------------------------
    |
    | base_cents:           costo spedizione in centesimi (default 10,00€)
    | free_threshold_cents: soglia spedizione gratuita in centesimi (default 69,00€)
    |
    */

    'base_cents'           => env('SHIPPING_BASE_CENTS', 1000),
    'free_threshold_cents' => env('FREE_SHIPPING_THRESHOLD_CENTS', 6900),

];
