<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Enemy;

use PeeHaa\AerysRealmII\User\User;
use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

abstract class Enemy
{
    /** @var int */
    private $id;

    /** @var int */
    private $level;

    /** @var string */
    private $description;

    /** @var int */
    private $hitPoints;

    /** @var AttackPoints */
    private $attackPoints;

    public function __construct(int $id, int $level, string $description, int $hitPoints, AttackPoints $attackPoints)
    {
        $this->id           = $id;
        $this->level        = $level;
        $this->description  = $description;
        $this->hitPoints    = $hitPoints;
        $this->attackPoints = $attackPoints;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getHitPoints(): int
    {
        return $this->hitPoints;
    }

    public function getAttackPoints(): AttackPoints
    {
        return $this->attackPoints;
    }

    /*
     * base chance of a miss is 30%
     * every level below enemy adds 5%
     * every level above enemy subtracts 5%
     * to a minimum of 5% and a maximum of 95%
     */
    public function doesAttackHit(User $user): bool
    {
        $missChance = 30;

        $extraChanceBasedOnLevel = ($this->getLevel() - $user->getLevel()->getNumeric()) * 5;

        $missChance += $extraChanceBasedOnLevel;

        if ($missChance < 5) {
            $missChance = 5;
        }

        if ($missChance > 95) {
            $missChance = 95;
        }

        if (random_int(0, 100) > $missChance) {
            return true;
        }

        return false;
    }

    public function registerAttack(User $user): int
    {
        $hitPointsFromLevelDifference = $user->getLevel()->getNumeric() - $this->getLevel();

        if ($hitPointsFromLevelDifference > 0) {
            $hitPointsFromLevelDifference = random_int(0, $hitPointsFromLevelDifference);
        }

        $hitPoints = random_int(
            $user->getLevel()->getAttackPoints()->getMinimum(),
            $user->getLevel()->getAttackPoints()->getMaximum()
        ) + $hitPointsFromLevelDifference;

        if ($hitPoints < 1) {
            $hitPoints = 1;
        }

        $this->hitPoints -= $hitPoints;

        return (int) ceil($hitPoints);
    }
}
