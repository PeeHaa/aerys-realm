<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command;

use PeeHaa\AerysRealmII\Controller\ClientConnect as Controller;
use PeeHaa\AerysRealmII\Request\Request;

class Connect extends Command
{
    public function __construct()
    {
        parent::__construct([Controller::class, 'process'], new AccessLevel(AccessLevel::GUEST));
    }

    public static function matches(Request $request): bool
    {
        return $request->isCommand('connect') && !$request->hasParameters();
    }
}
