<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command\Log;

use PeeHaa\AerysRealmII\Command\AccessLevel;
use PeeHaa\AerysRealmII\Command\Command;
use PeeHaa\AerysRealmII\Controller\Log\Clear as Controller;
use PeeHaa\AerysRealmII\Request\Request;

class Clear extends Command
{
    public function __construct()
    {
        parent::__construct([Controller::class, 'process'], new AccessLevel(AccessLevel::USER));
    }

    public static function matches(Request $request): bool
    {
        return $request->isCommand('clear') && !$request->hasParameters();
    }
}
