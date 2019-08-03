<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Tile;

use PeeHaa\AerysRealmII\ValueObject\Position;

class Water extends InAccessibleTile
{
    public function __construct(Position $position)
    {
        parent::__construct('Deep dark water', $position);
    }
}
