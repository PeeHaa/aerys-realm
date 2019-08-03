<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Tile;

use PeeHaa\AerysRealmII\ValueObject\Position;

class MagicTower extends AccessibleTile
{
    public function __construct(Position $position)
    {
        parent::__construct('A Magic tower', $position);
    }
}
