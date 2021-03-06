<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Tile;

use PeeHaa\AerysRealmII\ValueObject\Position;

class Bushes extends InAccessibleTile
{
    public function __construct(Position $position)
    {
        parent::__construct('Thick impenetrable bushes', $position);
    }
}
