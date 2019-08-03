<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command;

use PeeHaa\AerysRealmII\Enum;

class AccessLevel extends Enum
{
    public const GUEST = 1;
    public const USER  = 2;
    public const ADMIN = 3;
}
