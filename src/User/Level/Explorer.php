<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

use PeeHaa\AerysRealmII\ValueObject\AttackPoints;

class Explorer extends Level
{
    public function __construct()
    {
        parent::__construct(4, 'Explorer', 'Ready to rule the starters realm!', 30, new AttackPoints(5, 8), 35);
    }
}
