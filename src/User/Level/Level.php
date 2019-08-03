<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

abstract class Level
{
    /** @var int */
    private $numeric;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var int */
    private $experiencePoints;

    /** @var AttackPoints */
    private $attackPoints;

    /** @var int */
    private $hitPoints;

    public function __construct(
        int $numeric,
        string $name,
        string $description,
        int $experiencePoints,
        AttackPoints $attackPoints,
        int $hitPoints
    ) {
        $this->numeric          = $numeric;
        $this->name             = $name;
        $this->description      = $description;
        $this->experiencePoints = $experiencePoints;
        $this->attackPoints     = $attackPoints;
        $this->hitPoints        = $hitPoints;
    }

    public function getNumeric(): int
    {
        return $this->numeric;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getExperiencePoints(): int
    {
        return $this->experiencePoints;
    }

    public function getAttackPoints(): AttackPoints
    {
        return $this->attackPoints;
    }

    public function getHitPoints(): int
    {
        return $this->hitPoints;
    }
}
