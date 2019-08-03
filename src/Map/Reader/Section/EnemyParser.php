<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Reader\Section;

use PeeHaa\AerysRealmII\Map\Reader\MapImage;
use PeeHaa\AerysRealmII\Map\Specifications\Enemies as EnemiesSpecification;
use PeeHaa\AerysRealmII\Map\Specifications\EnemiesPositions;
use PeeHaa\AerysRealmII\Map\Specifications\Enemy;
use PeeHaa\AerysRealmII\Map\Specifications\EnemyPositions;

class EnemyParser
{
    public function parse(MapImage $mapImage, EnemiesSpecification $specification): EnemiesPositions
    {
        $enemies = [];

        foreach ($specification as $enemy) {
            $enemies[$enemy->getId()] = [
                'enemy'     => $enemy,
                'positions' => [],
            ];

            foreach ($mapImage->getEnemiesIterator() as $mapImagePixel) {
                if (!$specification->colorHasDefinedEnemy($mapImagePixel->color())) {
                    continue;
                }

                if (!$enemy->colorMatches($mapImagePixel->color())) {
                    continue;
                }

                $enemies[$enemy->getId()]['positions'][] = $mapImagePixel->position();
            }
        }

        return new EnemiesPositions(...$this->getEnemyPositions($enemies));
    }

    /**
     * @param Enemy[] $enemies
     * @return EnemyPositions[]
     */
    private function getEnemyPositions(array $enemies): array
    {
        $enemiesPositions = [];

        foreach ($enemies as $enemy) {
            $enemiesPositions[] = new EnemyPositions($enemy['enemy'], ...$enemy['positions']);
        }

        return $enemiesPositions;
    }
}
