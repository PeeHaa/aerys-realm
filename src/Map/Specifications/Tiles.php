<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Specifications;

use PeeHaa\AerysRealmII\ValueObject\Color;

class Tiles
{
    /** @var Tile[] */
    private $tiles = [];

    public function __construct(Tile ...$tiles)
    {
        $this->tiles = $tiles;
    }

    public function getTileClassByColor(Color $color): string
    {
        foreach ($this->tiles as $tile) {
            if (!$tile->colorMatches($color)) {
                continue;
            }

            return $tile->className();
        }

        throw new \Exception('Invalid color in map file.');
    }
}
