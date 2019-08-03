<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Specifications;

class EnemiesPositions implements \Iterator
{
    private $enemiesPositions = [];

    public function __construct(EnemyPositions ...$enemiesPositions)
    {
        $this->enemiesPositions = $enemiesPositions;
    }

    public function current(): EnemyPositions
    {
        return current($this->enemiesPositions);
    }

    public function next()
    {
        next($this->enemiesPositions);
    }

    public function key(): ?int
    {
        return key($this->enemiesPositions);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind()
    {
        reset($this->enemiesPositions);
    }
}
