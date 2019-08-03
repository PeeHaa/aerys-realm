<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class Apprentice extends Level
{
    public function __construct()
    {
        parent::__construct(2, 'Apprentice', 'Still too fresh to go out there, but at least can handle a sword.', 5, new AttackPoints(0, 2), 10);
    }
}
