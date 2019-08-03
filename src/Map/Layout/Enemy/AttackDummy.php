<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Enemy;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class AttackDummy extends Enemy
{
    public function __construct(int $id)
    {
        parent::__construct($id, 1, 'An attack dummy', 10, new AttackPoints(0, 0));
    }
}
