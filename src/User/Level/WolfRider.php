<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class WolfRider extends Level
{
    public function __construct()
    {
        parent::__construct(6, 'Wolf Rider', 'Rides wolves for fun and profit', 100, new AttackPoints(7, 15), 55);
    }
}
