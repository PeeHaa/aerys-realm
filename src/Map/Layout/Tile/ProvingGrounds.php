<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Tile;

use PeeHaa\AerysRealmII\ValueObject\Position;

class ProvingGrounds extends AccessibleTile
{
    public function __construct(Position $position)
    {
        parent::__construct('A part of the proving grounds', $position);
    }
}
