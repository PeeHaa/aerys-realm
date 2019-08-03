<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\ValueObject;

class AttackPoints
{
    private $minimum;

    private $maximum;

    public function __construct(int $minimum, int $maximum)
    {
        $this->minimum = $minimum;
        $this->maximum = $maximum;
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
