<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Specifications;

use PeeHaa\AerysRealmII\ValueObject\Color;

class Tile
{
    /** @var Color */
    private $color;

    /** @var string */
    private $className;

    public function __construct(Color $color, string $className)
    {
        $this->color     = $color;
        $this->className = $className;
    }

    public function colorMatches(Color $color): bool
    {
        return $this->color->equals($color);
    }

    public function className(): string
    {
        return $this->className;
    }
}
