<?php
namespace App\ValueObjects;

use App\Models\Currency;
use InvalidArgumentException;
use OverflowException;

final class Money
{
    private function __construct(
        private readonly int $amount,
        private readonly Currency $currency
    )
    {}

    public function fromMinorUnits (int $amount, Currency $currency): self
    {
        return new self($amount, $currency);
    }

    public function fromDecimal (int $amount, Currency $currency): self
    {
        if (! preg_match('/^(0|[1-9]\d*)(?:\.(\d+))?$/', $amount, $matches)) {
            throw new InvalidArgumentException(
                'Amount must be a non-negative decimal string.'
            );
        }

        $whole = $matches[1];
        $fraction = $matches[2];
        $precision = $currency->minor_unit;

        if (strlen($fraction) > $precision) {
            throw new InvalidArgumentException(
                "Currency {$currency->code} supports only {$precision} decimal places."
            );
        }

        $fraction = str_pad($fraction, $precision, '0');

        $minorUnitString = ltrim($whole . $fraction, '0');
        $minorUnitString = $minorUnitString === '' ? '0' : $minorUnitString;

        $max = (string) PHP_INT_MAX;

        if (
            strlen($minorUnitString) > strlen($max) ||
            (
                strlen($minorUnitString) === strlen($max) &&
                strcmp($minorUnitString, $max) > 0
            )
        ) {
            throw new OverflowException('Amount exceeds the supported integer range.');
        }

        return new self((int) $minorUnitString, $currency);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function toDecimal(): string
    {
        $precision = $this->currency->minor_unit;
        $digits = (string) $this->amount;

        if ($precision === 0) {
            return $digits;
        }

        $digits = str_pad($digits, $precision + 1, '0', STR_PAD_LEFT);

        return substr($digits, 0, -$precision)
            . '.'
            . substr($digits, -$precision);
    }

    public function add(Money $other): self
    {
        $this->assertSameCurrency($other);

        if ($other->amount > 0 && $this->amount > PHP_INT_MAX - $other->amount) {
            throw new OverflowException('Money addition overflow.');
        }

        if ($other->amount < 0 && $this->amount < PHP_INT_MIN - $other->amount) {
            throw new OverflowException('Money addition overflow.');
        }

        return new self(
            $this->amount + $other->amount,
            $this->currency
        );
    }

    public function subtract(Money $other): self
    {
        $this->assertSameCurrency($other);

        if ($other->amount === PHP_INT_MIN) {
            throw new OverflowException('Money subtraction overflow.');
        }

        return $this->add(
            new self(-$other->amount, $other->currency)
        );
    }

    public function equals(Money $other): bool
    {
        $this->assertSameCurrency($other);

        return $this->amount === $other->amount;
    }

    private function assertSameCurrency(Money $other): void
    {
        if ($this->currency->code !== $other->currency->code) {
            throw new InvalidArgumentException(
                'Cannot perform arithmetic with different currencies.'
            );
        }
    }
}
