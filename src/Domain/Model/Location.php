<?php

declare(strict_types=1);

namespace Fulll\Domain\Model;

final readonly class Location
{
    public function __construct(
        private ?float $lat = null,
        private ?float $lng = null,
        private ?float $alt = null,
    ) {}

    public function equals(self $other): bool
    {
        return $this->lat === $other->lat
            && $this->lng === $other->lng
            && $this->alt === $other->alt;
    }
}
