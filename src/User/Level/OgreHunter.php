<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class OgreHunter extends Level
{
    public function __construct()
    {
        parent::__construct(8, 'Ogre Hunter', 'Has a bracelet of ogre teeth on his arm', 300, new AttackPoints(12, 20), 70);
    }
}
