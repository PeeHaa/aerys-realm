<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Specifications;

use PeeHaa\AerysRealmII\ValueObject\Color;

class Enemy
{
    /** @var int */
    private $id;

    /** @var Color */
    private $color;

    /** @var string */
    private $className;

    /** @var int */
    private $minimum;

    /** @var int */
    private $maximum;

    public function __construct(int $id, Color $color, string $className, int $minimum, int $maximum)
    {
        $this->id        = $id;
        $this->color     = $color;
        $this->className = $className;
        $this->minimum   = $minimum;
        $this->maximum   = $maximum;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function colorMatches(Color $color): bool
    {
        return $this->color->equals($color);
    }

    public function className(): string
    {
        return $this->className;
    }

    public function getMinimum(): int
    {
        return $this->minimum;
    }

    public function getMaximum(): int
    {
        return $this->maximum;
    }
}
