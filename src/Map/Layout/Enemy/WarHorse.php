<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Enemy;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class WarHorse extends Enemy
{
    public function __construct(int $id)
    {
        parent::__construct($id, 5, 'A war horse', 30, new AttackPoints(4, 7));
    }
}
