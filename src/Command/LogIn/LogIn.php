<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command\LogIn;

use PeeHaa\AerysRealmII\Command\AccessLevel;
use PeeHaa\AerysRealmII\Command\Command;
use PeeHaa\AerysRealmII\Controller\LogIn\LogIn as Controller;
use PeeHaa\AerysRealmII\Request\Request;

class LogIn extends Command
{
    public function __construct()
    {
        parent::__construct([Controller::class, 'process'], new AccessLevel(AccessLevel::GUEST));
    }

    public static function matches(Request $request): bool
    {
        return $request->isCommand('login') && !$request->hasParameters();
    }
}
