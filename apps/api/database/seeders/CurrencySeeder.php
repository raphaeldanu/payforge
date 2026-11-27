<?php

namespace Database\Seeders;

use App\Enums\CurrencyStatus;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'minor_unit' => 2,
                'status' => CurrencyStatus::ACTIVE,
            ],
            [
                'code' => 'IDR',
                'name' => 'Indonesian Rupiah',
                'symbol' => 'Rp',
                'minor_unit' => 0,
                'status' => CurrencyStatus::ACTIVE,
            ],
            [
                'code' => 'JPY',
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'minor_unit' => 0,
                'status' => CurrencyStatus::ACTIVE,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'minor_unit' => 2,
                'status' => CurrencyStatus::ACTIVE,
            ],
            [
                'code' => 'SGD',
                'name' => 'Singapore Dollar',
                'symbol' => 'S$',
                'minor_unit' => 2,
                'status' => CurrencyStatus::ACTIVE,
            ],
        ];

        Currency::upsert($currencies, ['code'], ['name', 'symbol', 'minor_unit']);
    }
}
