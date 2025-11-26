<?php

if (! function_exists('currency_gnf')) {
    function currency_gnf($amount): string
    {
        if ($amount === null || $amount === '') return '—';
        return number_format((float) $amount, 0, ',', ' ') . ' GNF';
    }
}
