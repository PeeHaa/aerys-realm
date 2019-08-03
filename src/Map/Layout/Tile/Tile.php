<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Tile;

use PeeHaa\AerysRealmII\ValueObject\Position;

abstract class Tile
{
    /** @var bool */
    private $accessible;

    /** @var string */
    private $description;

    /** @var Position */
    private $position;

    public function __construct(bool $accessible, string $description, Position $position)
    {
        $this->accessible  = $accessible;
        $this->description = $description;
        $this->position    = $position;
    }

    public function isAccessible(): bool
    {
        return $this->accessible;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }
}
