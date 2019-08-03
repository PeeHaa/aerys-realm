<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class Newb extends Level
{
    public function __construct()
    {
        parent::__construct(1, 'Newb', 'Has no idea what is going on.', 0, new AttackPoints(0, 1), 5);
    }
}
