<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command\Admin;

use PeeHaa\AerysRealmII\Command\AccessLevel;
use PeeHaa\AerysRealmII\Command\Command;
use PeeHaa\AerysRealmII\Controller\Admin\Online as Controller;
use PeeHaa\AerysRealmII\Request\Request;

class Online extends Command
{
    public function __construct()
    {
        parent::__construct([Controller::class, 'process'], new AccessLevel(AccessLevel::ADMIN));
    }

    public static function matches(Request $request): bool
    {
        return $request->isCommand('online') && !$request->hasParameters();
    }
}
