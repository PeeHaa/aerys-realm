<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class WolfTamer extends Level
{
    public function __construct()
    {
        parent::__construct(5, 'Wolf Tamer', 'Sleeps with wild wolfs to relax.', 60, new AttackPoints(7, 12), 50);
    }
}
