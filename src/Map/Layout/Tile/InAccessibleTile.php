<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Tile;

use PeeHaa\AerysRealmII\ValueObject\Position;

abstract class InAccessibleTile extends Tile
{
    public function __construct(string $description, Position $position)
    {
        parent::__construct(false, $description, $position);
    }
}
