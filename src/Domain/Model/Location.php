<?php
namespace Fulll\Domain\Model;

final readonly class Location
{
    public function __construct(
        public float $lat,
        public float $lng,
        public ?float $alt = null
    ) {}

    public function equals(Location $other): bool
    {
        return $this->lat === $other->lat
            && $this->lng === $other->lng
            && $this->alt === $other->alt;
    }
}
