<?php

declare(strict_types=1);

namespace Fulll\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Location
{
    #[ORM\Column(type: 'float', nullable: true)]
    public ?float $lat = null;

    #[ORM\Column(type: 'float', nullable: true)]
    public ?float $lng = null;

    #[ORM\Column(type: 'float', nullable: true)]
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
