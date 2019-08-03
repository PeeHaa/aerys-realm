<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Reader\Section;

use PeeHaa\AerysRealmII\Map\Layout\Tiles;
use PeeHaa\AerysRealmII\Map\Reader\MapImage;
use PeeHaa\AerysRealmII\Map\Specifications\Tiles as TilesSpecifications;

class TileParser
{
    public function parse(MapImage $mapImage, TilesSpecifications $specification): Tiles
    {
        $tiles = [];

        foreach ($mapImage->getTilesIterator() as $mapImagePixel) {
            $tileClassName = $specification->getTileClassByColor($mapImagePixel->color());

            $tiles[] = new $tileClassName($mapImagePixel->position());
        }

        return new Tiles(...$tiles);
    }
}
