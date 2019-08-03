<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout;

use PeeHaa\AerysRealmII\Map\Layout\Tile\Tile;

class Tiles implements \Iterator
{
    /** @var Tile[] */
    private $tiles = [];

    public function __construct(Tile ...$tiles)
    {
        $this->tiles = $tiles;
    }

    public function current(): Tile
    {
        return current($this->tiles);
    }

    public function next()
    {
        next($this->tiles);
    }

    public function key(): ?int
    {
        return key($this->tiles);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind()
    {
        reset($this->tiles);
    }
}
