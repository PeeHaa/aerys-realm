<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Game;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Clients;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\Enemy;
use PeeHaa\AerysRealmII\Map\Layout\Npc\Npc;
use PeeHaa\AerysRealmII\Map\Layout\Tile\Tile;
use PeeHaa\AerysRealmII\Response\CommandResponse;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Storage\User as UserStorage;
use PeeHaa\AerysRealmII\ValueObject\MapPosition;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class Engine
{
    /** @var WebSocket */
    private $webSocket;

    /** @var UserStorage */
    private $userStorage;

    /** @var array|MapHandler[] */
    private $mapHandlers = [];

    /** @var Clients */
    private $clients;

    public function __construct(WebSocket $webSocket, UserStorage $userStorage, MapHandler ...$mapHandlers)
    {
        $this->webSocket   = $webSocket;
        $this->userStorage = $userStorage;

        foreach ($mapHandlers as $mapHandler) {
            $this->mapHandlers[$mapHandler->getId()] = $mapHandler;
        }

        $this->clients = new Clients();
    }

    public function getClients(): Clients
    {
        return $this->clients;
    }

    public function tick(): Promise
    {
        return call(function () {
            foreach ($this->mapHandlers as $mapHandler) {
                yield $mapHandler->tick();
            }
        });
    }

    public function persist(): Promise
    {
        $promises = [];

        foreach ($this->clients as $client) {
            $promises[] = $this->userStorage->persist($client->getUser());
        }

        return Promise\all($promises);
    }

    public function placeClientOnMap(Client $client): Promise
    {
        return call(function() use ($client) {
            yield $this->checkUniqueUser($client);

            $this->clients->add($client);

            yield $this->mapHandlers[$client->getUser()->getMapPosition()->getMapId()]->addClient($client);
        });
    }

    public function checkUniqueUser(Client $client): Promise
    {
        return call(function () use ($client) {
            foreach ($this->clients as $existingClient) {
                if ($existingClient->getUser()->getId() !== $client->getUser()->getId()) {
                    continue;
                }

                yield $this->webSocket->sendToClient($existingClient, new CommandResponse('reset'));

                yield $this->disconnectClient($existingClient);
            }
        });
    }

    public function disconnectClient(Client $client): Promise
    {
        return call(function () use ($client) {
            yield $this->mapHandlers[$client->getUser()->getMapPosition()->getMapId()]->removeClient($client);

            $this->clients->remove($client->getId());
        });
    }

    public function moveClient(Client $client, MapPosition $newMapPosition, string $direction): Promise
    {
        return call(function () use ($client, $newMapPosition, $direction) {
            yield $this->mapHandlers[$client->getUser()->getMapPosition()->getMapId()]->removeClient($client, $direction);

            $client->getUser()->moveToPosition($newMapPosition);

            yield $this->mapHandlers[$client->getUser()->getMapPosition()->getMapId()]->addClient($client);
        });
    }

    public function getTileClientIsOn(Client $client): Tile
    {
        return $this->mapHandlers[$client->getUser()->getMapPosition()->getMapId()]->getTileClientIsOn($client);
    }

    public function getTileOnMapPosition(MapPosition $mapPosition): Tile
    {
        return $this->mapHandlers[$mapPosition->getMapId()]->getTileOnPosition($mapPosition->getPosition());
    }

    public function getEnemyOnMapPosition(MapPosition $mapPosition): ?Enemy
    {
        return $this->mapHandlers[$mapPosition->getMapId()]->getEnemyOnPosition($mapPosition->getPosition());
    }

    public function getNpcOnMapPosition(MapPosition $mapPosition): ?Npc
    {
        return $this->mapHandlers[$mapPosition->getMapId()]->getNpcOnPosition($mapPosition->getPosition());
    }

    public function getClientsOnMapPosition(MapPosition $mapPosition): Clients
    {
        return $this->mapHandlers[$mapPosition->getMapId()]->getClientsOnPosition($mapPosition->getPosition());
    }

    public function attack(Client $client): Promise
    {
        return $this->mapHandlers[$client->getUser()->getMapPosition()->getMapId()]->attack($client);
    }
}
