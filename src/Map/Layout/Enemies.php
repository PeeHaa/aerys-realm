<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout;

use PeeHaa\AerysRealmII\Map\Layout\Enemy\Enemy;

class Enemies implements \Iterator
{
    /** @var Enemy[] */
    private $enemies = [];

    public function __construct(Enemy ...$enemies)
    {
        $this->enemies = $enemies;
    }

    public function current(): Enemy
    {
        return current($this->enemies);
    }

    public function next()
    {
        next($this->enemies);
    }

    public function key(): ?int
    {
        return key($this->enemies);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind()
    {
        reset($this->enemies);
    }
}
