<?php

declare(strict_types=1);

namespace Fulll\Domain\Model;

class Location
{
    public ?float $lat = null;

    public ?float $lng = null;

    public ?float $alt = null;

    public function __construct(?float $lat = null, ?float $lng = null, ?float $alt = null)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->alt = $alt;
    }

    public function equals(self $other): bool
    {
        return $this->lat === $other->lat
            && $this->lng === $other->lng
            && $this->alt === $other->alt;
    }
}
