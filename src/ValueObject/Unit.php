<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\ValueObjectValidationException;

class Unit
{
    private string $unit;

    private const KILOGRAM = 'kilogram';
    private const MILLIGRAM = 'milligram';
    private const DECAGRAM = 'decagram';
    private const GRAM = 'gram';

    private const LITER = 'liter';
    private const MILLILITER = 'milliliter';

    private const TEASPOON = 'teaspoon';
    private const SPOON = 'spoon';
    private const GLASS = 'glass';
    private const PACK = 'pack';

    private const UNITS = [
        self::KILOGRAM,
        self::MILLIGRAM,
        self::DECAGRAM,
        self::GRAM,
        self::LITER,
        self::MILLILITER,
        self::TEASPOON,
        self::SPOON,
        self::GLASS,
        self::PACK
    ];

    private function __construct(string $unit)
    {
        $this->validate($unit);
        $this->unit = $unit;
    }

    public static function fromString($unit): self
    {
        return new self($unit);
    }

    public static function kilogram(): self
    {
        return new self(self::KILOGRAM);
    }

    public static function milligram(): self
    {
        return new self(self::MILLIGRAM);
    }

    public static function decagram(): self
    {
        return new self(self::DECAGRAM);
    }

    public static function gram(): self
    {
        return new self(self::GRAM);
    }

    public static function liter(): self
    {
        return new self(self::LITER);
    }

    public static function milliliter(): self
    {
        return new self(self::MILLILITER);
    }

    public static function teaspoon(): self
    {
        return new self(self::TEASPOON);
    }

    public static function spoon(): self
    {
        return new self(self::SPOON);
    }

    public static function glass(): self
    {
        return new self(self::GLASS);
    }

    public static function pack(): self
    {
        return new self(self::PACK);
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function __toString(): string
    {
        return $this->unit;
    }

    public function equals(self $unit): bool
    {
        return $this->unit === $unit->unit;
    }

    private function validate(string $unit): void
    {
        if (!in_array($unit, self::UNITS)) {
            throw new ValueObjectValidationException("string: $unit is not valid Unit.");
        }
    }

}
