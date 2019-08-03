<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command;

use PeeHaa\AerysRealmII\Controller\ClientDisconnect as Controller;
use PeeHaa\AerysRealmII\Request\Request;

class Disconnect extends Command
{
    public function __construct()
    {
        parent::__construct([Controller::class, 'process'], new AccessLevel(AccessLevel::USER));
    }

    public static function matches(Request $request): bool
    {
        return $request->isCommand('disconnect') && !$request->hasParameters();
    }
}
