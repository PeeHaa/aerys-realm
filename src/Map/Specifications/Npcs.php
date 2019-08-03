<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Specifications;

use PeeHaa\AerysRealmII\ValueObject\Color;

class Npcs implements \Iterator
{
    /** @var Npc[] */
    private $npcs = [];

    public function __construct(Npc ...$npcs)
    {
        $this->npcs = $npcs;
    }

    public function colorHasDefinedNpc(Color $color): bool
    {
        foreach ($this->npcs as $enemy) {
            if (!$enemy->colorMatches($color)) {
                continue;
            }

            return true;
        }

        return false;
    }

    public function getNpcByColor(Color $color): Npc
    {
        foreach ($this->npcs as $npc) {
            if (!$npc->colorMatches($color)) {
                continue;
            }

            return $npc;
        }
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
