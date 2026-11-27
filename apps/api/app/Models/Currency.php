<?php

namespace App\Models;

use App\Enums\CurrencyStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'name', 'symbol', 'minor_unit', 'status'])]
class Currency extends Model
{
    protected function casts(): array
    {
        return [
            'minor_unit' => 'integer',
            'status' => CurrencyStatus::class
        ];
    }

    public function isActive(): bool
    {
        return $this->status === CurrencyStatus::ACTIVE;
    }
}
