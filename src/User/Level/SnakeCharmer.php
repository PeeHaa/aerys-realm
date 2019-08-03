<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class SnakeCharmer extends Level
{
    public function __construct()
    {
        parent::__construct(7, 'Snake charmer', 'Sneks are no match', 175, new AttackPoints(9, 18), 62);
    }
}
