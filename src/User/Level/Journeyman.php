<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class Journeyman extends Level
{
    public function __construct()
    {
        parent::__construct(3, 'Journeyman', 'Knows how to handle a sword.', 17, new AttackPoints(2, 4), 20);
    }
}
