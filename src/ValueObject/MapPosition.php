<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\ValueObject;

class MapPosition
{
    /** @var string */
    private $mapId;

    /** @var Position */
    private $position;

    public function __construct(string $mapId, Position $position)
    {
        $this->mapId    = $mapId;
        $this->position = $position;
    }

    public function getMapId(): string
    {
        return $this->mapId;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function x(): int
    {
        return $this->position->x();
    }

    public function y(): int
    {
        return $this->position->y();
    }

    public function moveUp(): self
    {
        return new MapPosition($this->mapId, $this->position->moveUp());
    }

    public function moveDown(): self
    {
        return new MapPosition($this->mapId, $this->position->moveDown());
    }

    public function moveLeft(): self
    {
        return new MapPosition($this->mapId, $this->position->moveLeft());
    }

    public function moveRight(): self
    {
        return new MapPosition($this->mapId, $this->position->moveRight());
    }

    public function moveToPosition(Position $position):self
    {
        return new MapPosition($this->mapId, $position);
    }
}
