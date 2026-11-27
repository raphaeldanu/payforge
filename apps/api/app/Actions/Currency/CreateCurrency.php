<?php

namespace App\Actions\Currency;

use App\Enums\CurrencyStatus;
use App\Models\Currency;

class CreateCurrency
{
    public function execute(array $data): Currency
    {
        return Currency::create([
            'code' => strtoupper($data['code']),
            'name' => $data['name'],
            'symbol' => $data['symbol'] ?? null,
            'minor_unit' => $data['minor_unit'],
            'status' => CurrencyStatus::ACTIVE,
        ]);
    }
}
