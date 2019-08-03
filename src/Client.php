<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII;

use PeeHaa\AerysRealmII\Command\AccessLevel;
use PeeHaa\AerysRealmII\User\User;

class Client
{
    /** @var int */
    private $id;

    /** @var User|null */
    private $user = null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function logIn(User $user): void
    {
        $this->user = $user;
    }

    public function isLoggedIn(): bool
    {
        return $this->user !== null;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getAccessLevel(): AccessLevel
    {
        if ($this->user === null) {
            return new AccessLevel(AccessLevel::GUEST);
        }

        if ($this->user->isAdmin()) {
            return new AccessLevel(AccessLevel::ADMIN);
        }

        return new AccessLevel(AccessLevel::USER);
    }
}
