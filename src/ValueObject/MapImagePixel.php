<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\ValueObject;

class MapImagePixel
{
    /** @var Position */
    private $position;

    /** @var Color */
    private $color;

    public function __construct(Position $position, Color $color)
    {
        $this->position = $position;
        $this->color    = $color;
    }

    public function position(): Position
    {
        return $this->position;
    }

    public function color(): Color
    {
        return $this->color;
    }
}
