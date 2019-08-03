<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\ValueObject;

class Position
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function x(): int
    {
        return $this->x;
    }

    public function y(): int
    {
        return $this->y;
    }

    public function moveUp(): Position
    {
        return new Position($this->x, $this->y - 1);
    }

    public function moveDown(): Position
    {
        return new Position($this->x, $this->y + 1);
    }

    public function moveLeft(): Position
    {
        return new Position($this->x - 1, $this->y);
    }

    public function moveRight(): Position
    {
        return new Position($this->x + 1, $this->y);
    }

    public function __toString(): string
    {
        return sprintf('%s:%s', $this->x, $this->y);
    }
}
