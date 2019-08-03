<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Specifications;

class Specifications
{
    /** @var string */
    private $id;

    /** @var string */
    private $name;

    /** @var Tiles */
    private $tiles;

    /** @var Enemies */
    private $enemies;

    /** @var Npcs */
    private $npcs;

    public function __construct(string $id, string $name, Tiles $tiles, Enemies $enemies, Npcs $npcs)
    {
        $this->id      = $id;
        $this->name    = $name;
        $this->tiles   = $tiles;
        $this->enemies = $enemies;
        $this->npcs    = $npcs;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function tiles(): Tiles
    {
        return $this->tiles;
    }

    public function getEnemies(): Enemies
    {
        return $this->enemies;
    }

    public function getNpcs(): Npcs
    {
        return $this->npcs;
    }
}
