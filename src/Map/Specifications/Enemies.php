<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Specifications;

use PeeHaa\AerysRealmII\ValueObject\Color;

class Enemies implements \Iterator
{
    /** @var Enemy[] */
    private $enemies = [];

    public function __construct(Enemy ...$enemies)
    {
        $this->enemies = $enemies;
    }

    public function colorHasDefinedEnemy(Color $color): bool
    {
        foreach ($this->enemies as $enemy) {
            if (!$enemy->colorMatches($color)) {
                continue;
            }

            return true;
        }

        return false;
    }

    public function getEnemyByColor(Color $color): Enemy
    {
        foreach ($this->enemies as $enemy) {
            if (!$enemy->colorMatches($color)) {
                continue;
            }

            return $enemy;
        }
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
