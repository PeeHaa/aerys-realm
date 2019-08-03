<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Enemy;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class Ogre extends Enemy
{
    public function __construct(int $id)
    {
        parent::__construct($id, 6, 'An ogre', 50, new AttackPoints(5, 10));
    }
}
