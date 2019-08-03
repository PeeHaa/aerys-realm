<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Enemy;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class ViciousDog extends Enemy
{
    public function __construct(int $id)
    {
        parent::__construct($id, 3, 'A vicious dog', 20, new AttackPoints(1, 3));
    }
}
