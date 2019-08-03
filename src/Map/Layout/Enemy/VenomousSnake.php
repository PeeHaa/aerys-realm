<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Enemy;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class VenomousSnake extends Enemy
{
    public function __construct(int $id)
    {
        parent::__construct($id, 4, 'A venomous snake', 25, new AttackPoints(3, 5));
    }
}
