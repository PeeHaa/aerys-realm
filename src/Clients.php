<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII;

use PeeHaa\AerysRealmII\User\User;

class Clients implements \Iterator, \Countable
{
    /** @var Client[] */
    private $clients = [];

    public function add(Client $client): self
    {
        $this->clients[$client->getId()] = $client;

        return $this;
    }

    public function remove(int $clientId): self
    {
        unset($this->clients[$clientId]);

        return $this;
    }

    public function getById(int $id): ?Client
    {
        return $this->clients[$id];
    }

    /**
     * @return Client[]
     */
    public function getClients(): array
    {
        return $this->clients;
    }

    public function logIn(Client $client, User $user): void
    {
        $this->clients[$client->getId()]->logIn($user);
    }

    public function filter(callable $callback): self
    {
        $clients = new Clients();

        foreach ($this->clients as $client) {
            if (!$callback($client)) {
                continue;
            }

            $clients->add($client);
        }

        return $clients;
    }

    public function each(callable $callback): self
    {
        foreach ($this->clients as $client) {
            $callback($client);
        }

        return $this;
    }

    public function getRandom(): Client
    {
        $clients = array_values($this->clients);

        return $clients[random_int(0, count($clients) - 1)];
    }

    public function getIds(): array
    {
        return array_reduce($this->clients, function (array $clientIds, Client $client) {
            $clientIds[] = $client->getId();

            return $clientIds;
        }, []);
    }

    public function current(): Client
    {
        return current($this->clients);
    }

    public function next()
    {
        next($this->clients);
    }

    public function key(): ?int
    {
        return key($this->clients);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind()
    {
        reset($this->clients);
    }

    public function count(): int
    {
        return count($this->clients);
    }
}
