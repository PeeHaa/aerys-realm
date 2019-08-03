<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout;

use PeeHaa\AerysRealmII\Map\Specifications\EnemiesPositions;
use PeeHaa\AerysRealmII\ValueObject\Position;

class Map
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var Position */
    private $spawnPoint;

    /** @var Tiles */
    private $tiles;

    /** @var EnemiesPositions */
    private $enemies;

    /** @var Npcs */
    private $npcs;

    public function __construct(
        string $id,
        string $name,
        Position $spawnPoint,
        Tiles $tiles,
        EnemiesPositions $enemies,
        Npcs $npcs
    ) {
        $this->id         = $id;
        $this->name       = $name;
        $this->spawnPoint = $spawnPoint;
        $this->tiles      = $tiles;
        $this->enemies    = $enemies;
        $this->npcs       = $npcs;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSpawnPoint(): Position
    {
        return $this->spawnPoint;
    }

    public function getTiles(): Tiles
    {
        return $this->tiles;
    }

    public function getEnemies(): EnemiesPositions
    {
        return $this->enemies;
    }

    public function getNpcs(): Npcs
    {
        return $this->npcs;
    }
}
