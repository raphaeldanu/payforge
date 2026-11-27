<?php

namespace App\Services;

use App\Actions\Currency\CreateCurrency;
use App\Actions\Currency\UpdateCurrency;
use App\Enums\CurrencyStatus;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService
{
    public function getAll(): Collection
    {
        return Currency::query()
            ->orderBy('code')
            ->get();
    }

    public function getActive(): Collection
    {
        return Currency::query()
            ->where('status', CurrencyStatus::ACTIVE)
            ->orderBy('code')
            ->get();
    }

    public function findByCode(string $code) {
        return Currency::query()
            ->where('code', strtoupper($code))
            ->first();
    }

    public function isSupported(string $code) {
        $currency = $this->findByCode($code);

        return $currency !== null && $currency->isActive();
    }

    public function create(array $data) {
        return app(CreateCurrency::class)->execute($data);
    }

    public function update(Currency $currency, array $data) {
        return app(UpdateCurrency::class)->execute($currency, $data);
    }

    public function activate(Currency $currency) {
        $currency->update([
            'status' => CurrencyStatus::ACTIVE
        ]);

        return $currency->refresh();
    }

    public function deactivate(Currency $currency) {
        $currency->update([
            'status' => CurrencyStatus::INACTIVE
        ]);

        return $currency->refresh();
    }
}
