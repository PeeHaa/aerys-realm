<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class DragonSlayer extends Level
{
    public function __construct()
    {
        parent::__construct(50, 'Dragon Slayer', 'Slayer of dragons.', 300000, new AttackPoints(500, 800), 20000);
    }
}
