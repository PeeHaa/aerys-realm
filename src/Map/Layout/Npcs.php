<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout;

use PeeHaa\AerysRealmII\Map\Layout\Npc\Npc;

class Npcs implements \Iterator
{
    /** @var Npc[] */
    private $npcs = [];

    public function __construct(Npc ...$npcs)
    {
        $this->npcs = $npcs;
    }

    public function current(): Npc
    {
        return current($this->npcs);
    }

    public function next()
    {
        next($this->npcs);
    }

    public function key(): ?int
    {
        return key($this->npcs);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind()
    {
        reset($this->npcs);
    }
}
