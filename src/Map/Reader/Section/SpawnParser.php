<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Reader\Section;

use PeeHaa\AerysRealmII\Map\Reader\MapImage;
use PeeHaa\AerysRealmII\ValueObject\Color;
use PeeHaa\AerysRealmII\ValueObject\Position;

class SpawnParser
{
    public function parse(MapImage $mapImage): Position
    {
        $spawnColor = new Color(136, 0, 21);

        foreach ($mapImage->getSpawnsIterators() as $mapImagePixel) {
            if (!$mapImagePixel->color()->equals($spawnColor)) {
                continue;
            }

            return $mapImagePixel->position();
        }

        throw new \Exception('Spawn point not found on map.');
    }
}
