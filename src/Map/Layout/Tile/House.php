<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Tile;

use PeeHaa\AerysRealmII\ValueObject\Position;

class House extends AccessibleTile
{
    public function __construct(Position $position)
    {
        parent::__construct('A cozy looking house', $position);
    }
}
