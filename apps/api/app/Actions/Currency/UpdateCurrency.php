<?php

namespace App\Actions\Currency;

use App\Enums\CurrencyStatus;
use App\Models\Currency;

class UpdateCurrency
{
    public function execute(Currency $currency, array $data): Currency
    {
        $currency->update([
            'name' => $data['name'] ?? $currency->name,
            'symbol' => array_key_exists('symbol', $data)
                ? $data['symbol']
                : $currency->symbol,
        ]);

        return $currency->refresh();
    }
}
