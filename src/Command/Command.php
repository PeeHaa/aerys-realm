<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command;

use PeeHaa\AerysRealmII\Request\Request;

abstract class Command
{
    /** @var callable */
    private $callable;

    /** @var AccessLevel */
    private $accessLevel;

    public function __construct(callable $callable, AccessLevel $accessLevel)
    {
        $this->callable    = $callable;
        $this->accessLevel = $accessLevel;
    }

    abstract public static function matches(Request $request): bool;

    public function getController(): callable
    {
        return $this->callable;
    }

    public function accessLevelMatches(AccessLevel $accessLevel): bool
    {
        if ($accessLevel->getValue() === AccessLevel::ADMIN && $this->accessLevel->getValue() === AccessLevel::USER) {
            return true;
        }

        return $this->accessLevel->getValue() === $accessLevel->getValue();
    }
}
