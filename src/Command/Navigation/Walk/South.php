<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command\Navigation\Walk;

use PeeHaa\AerysRealmII\Command\AccessLevel;
use PeeHaa\AerysRealmII\Command\Command;
use PeeHaa\AerysRealmII\Controller\Navigation\Walk\South as Controller;
use PeeHaa\AerysRealmII\Request\Request;

class South extends Command
{
    public function __construct()
    {
        parent::__construct([Controller::class, 'process'], new AccessLevel(AccessLevel::USER));
    }

    public static function matches(Request $request): bool
    {
        return $request->isCommand('walk')
            && $request->hasNumberOfParameters(1)
            && $request->getParameterAtIndex(0) === 'south';
    }
}
