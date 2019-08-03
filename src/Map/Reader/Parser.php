<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Reader;

use PeeHaa\AerysRealmII\Map\Layout\Map;
use PeeHaa\AerysRealmII\Map\Reader\Section\EnemyParser;
use PeeHaa\AerysRealmII\Map\Reader\Section\NpcParser;
use PeeHaa\AerysRealmII\Map\Reader\Section\SpawnParser;
use PeeHaa\AerysRealmII\Map\Reader\Section\TileParser;
use PeeHaa\AerysRealmII\Map\Specifications\Specifications;

class Parser
{
    /** @var SpawnParser */
    private $spawnParser;

    /** @var TileParser */
    private $tileParser;

    /** @var EnemyParser */
    private $enemyParser;

    /** @var NpcParser */
    private $npcParser;

    public function __construct(SpawnParser $spawnParser, TileParser $tileParser, EnemyParser $enemyParser, NpcParser $npcParser)
    {
        $this->spawnParser = $spawnParser;
        $this->tileParser  = $tileParser;
        $this->enemyParser = $enemyParser;
        $this->npcParser   = $npcParser;
    }

    public function parse(string $filename, Specifications $specifications): Map
    {
        $image = new MapImage($filename);

        return new Map(
            $specifications->getId(),
            $specifications->getName(),
            $this->spawnParser->parse($image),
            $this->tileParser->parse($image, $specifications->tiles()),
            $this->enemyParser->parse($image, $specifications->getEnemies()),
            $this->npcParser->parse($image, $specifications->getNpcs())
        );
    }
}
