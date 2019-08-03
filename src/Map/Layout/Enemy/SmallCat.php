<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Enemy;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class SmallCat extends Enemy
{
    public function __construct(int $id)
    {
        parent::__construct($id, 2, 'A small cat', 15, new AttackPoints(0, 1));
    }
}
