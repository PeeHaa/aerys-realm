<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User;

use PeeHaa\AerysRealmII\Map\Layout\Enemy\Enemy;
use PeeHaa\AerysRealmII\Map\Layout\Item\Item;
use PeeHaa\AerysRealmII\Map\Layout\Quest\Quest;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\User\Level\Level;
use PeeHaa\AerysRealmII\ValueObject\MapPosition;
use PeeHaa\AerysRealmII\ValueObject\Position;

class User
{
    /** @var int */
    private $id;

    /** @var string */
    private $username;

    /** @var string */
    private $passwordHash;

    /** @var string */
    private $emailAddress;

    /** @var MapPosition */
    private $mapPosition;

    /** @var Level */
    private $level;

    /** @var int */
    private $hitPoints;

    /** @var int */
    private $experiencePoints;

    /** @var bool */
    private $attacking;

    /** @var Quests */
    private $quests;

    /** @var Items */
    private $items;

    /** @var bool */
    private $admin;

    public function __construct(
        int $id,
        string $username,
        string $passwordHash,
        string $emailAddress,
        MapPosition $mapPosition,
        int $experiencePoints,
        Level $level,
        Quests $quests,
        Items $items,
        bool $admin
    ) {
        $this->id               = $id;
        $this->username         = $username;
        $this->passwordHash     = $passwordHash;
        $this->emailAddress     = $emailAddress;
        $this->mapPosition      = $mapPosition;
        $this->level            = $level;
        $this->hitPoints        = $this->level->getHitPoints();
        $this->experiencePoints = $experiencePoints;
        $this->attacking        = false;
        $this->quests           = $quests;
        $this->items            = $items;
        $this->admin            = $admin;
    }

    public static function fromRecordSet(array $recordSet, Ladder $ladder): self
    {
        $record = $recordSet[0];

        return new self(
            $record['id'],
            $record['username'],
            $record['password'],
            $record['email'],
            new MapPosition($record['map'], new Position($record['position_x'], $record['position_y'])),
            $record['xp'],
            $ladder->getLevelBasedOnExperiencePoints($record['xp']),
            Quests::fromUserRecordSet($recordSet),
            Items::fromUserRecordSet($recordSet),
            $record['admin']
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function getMapPosition(): MapPosition
    {
        return $this->mapPosition;
    }

    public function moveToPosition(MapPosition $mapPosition): void
    {
        $this->mapPosition = $mapPosition;
    }

    public function setLevel(Level $level): void
    {
        $this->level = $level;
    }

    public function getLevel(): Level
    {
        return $this->level;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function getHitPoints(): int
    {
        return $this->hitPoints;
    }

    public function getExperiencePoints(): int
    {
        return $this->experiencePoints;
    }

    public function addExperiencePoints(int $experiencePoints): void
    {
        $this->experiencePoints += $experiencePoints;
    }

    public function startAttack(): void
    {
        $this->attacking = true;
    }

    public function stopAttack(): void
    {
        $this->attacking = false;
    }

    public function isAttacking(): bool
    {
        return $this->attacking;
    }

    public function resetStats(): void
    {
        $this->attacking = false;
        $this->hitPoints = $this->level->getHitPoints();
    }

    /*
     * base chance of a miss is 25%
     * every level below enemy subtracts 5%
     * every level above enemy adds 5%
     * to a minimum of 5% and a maximum of 95%
     */
    public function doesAttackHit(Enemy $enemy): bool
    {
        $missChance = 25;

        $extraChanceBasedOnLevel = ($this->getLevel()->getNumeric() - $enemy->getLevel()) * 5;

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

    public function registerAttack(Enemy $enemy): int
    {
        $hitPointsFromLevelDifference = $enemy->getLevel() - $this->getLevel()->getNumeric();

        $hitPoints = random_int($enemy->getAttackPoints()->getMinimum(), $enemy->getAttackPoints()->getMaximum())
            + $hitPointsFromLevelDifference
        ;

        if ($hitPoints < 0) {
            $hitPoints = 0;
        }

        $this->hitPoints -= $hitPoints;

        return (int) ceil($hitPoints);
    }

    public function removeHitPoints(int $amount): void
    {
        $this->hitPoints -= $amount;
    }

    public function getQuests(): Quests
    {
        return $this->quests;
    }

    public function getQuest(string $questName): ?Quest
    {
        return $this->quests->getQuest($questName);
    }

    public function startQuest(string $questName): void
    {
        $this->quests->add(new $questName());
    }

    public function getItems(): Items
    {
        return $this->items;
    }

    public function getItem(string $itemName): ?Item
    {
        return $this->items->getItem($itemName);
    }

    public function addItem(Item $item): void
    {
        $this->items->add($item);
    }

    public function removeItem(string $className): void
    {
        $this->items->remove($className);
    }
}
