<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command\Help\Authenticated;

use PeeHaa\AerysRealmII\Command\AccessLevel;
use PeeHaa\AerysRealmII\Command\Command;
use PeeHaa\AerysRealmII\Controller\Help\Authenticated\Info as Controller;
use PeeHaa\AerysRealmII\Request\Request;

class Info extends Command
{
    public function __construct()
    {
        parent::__construct([Controller::class, 'process'], new AccessLevel(AccessLevel::USER));
    }

    public static function matches(Request $request): bool
    {
        return $request->isCommand('help')
            && $request->hasNumberOfParameters(1)
            && $request->getParameterAtIndex(0) === 'info'
        ;
    }
}
