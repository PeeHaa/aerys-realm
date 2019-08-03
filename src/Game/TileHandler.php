<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Game;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Clients;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\Enemy;
use PeeHaa\AerysRealmII\Map\Layout\Npc\Npc;
use PeeHaa\AerysRealmII\Map\Layout\Tile\Tile;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class TileHandler
{
    /** @var WebSocket */
    private $webSocket;

    /** @var Template */
    private $template;

    /** @var Tile */
    private $tile;

    /** @var Clients */
    private $clients = [];

    /** @var Enemy */
    private $enemy = null;

    /** @var Npc|null */
    private $npc = null;

    public function __construct(WebSocket $webSocket, Template $template, Tile $tile)
    {
        $this->webSocket = $webSocket;
        $this->template  = $template;
        $this->tile      = $tile;
        $this->clients   = new Clients();
    }

    public function getTile(): Tile
    {
        return $this->tile;
    }

    public function getPosition(): Position
    {
        return $this->tile->getPosition();
    }

    public function placeNpc(Npc $npc): void
    {
        $this->npc = $npc;
    }

    public function addClient(Client $client): Promise
    {
        return call(function () use ($client) {
            yield $this->webSocket->sendToClients(new Render($this->template->render('/movement/player-entered', [
                'player' => $client->getUser(),
            ])), $this->clients);

            $this->clients->add($client);
        });
    }

    public function removeClient(Client $client, ?string $direction = null): Promise
    {
        $this->clients->remove($client->getId());

        return $this->webSocket->sendToClients(new Render($this->template->render('/movement/player-left', [
            'direction' => $direction,
            'player'    => $client->getUser(),
        ])), $this->clients);
    }

    public function spawnClient(Client $client): Promise
    {
        return call(function () use ($client) {
            yield $this->webSocket->sendToClients(new Render($this->template->render('/movement/player-spawned-other', [
                'player' => $client->getUser(),
            ])), $this->clients);

            yield $this->webSocket->sendToClient($client, new Render($this->template->render('/movement/player-spawned-self', [
                'tile' => $this->tile,
            ])));

            $this->clients->add($client);
        });
    }

    public function killClient(Client $client): Promise
    {
        $this->clients->remove($client->getId());

        return $this->webSocket->sendToClients(new Render($this->template->render('/movement/player-disintegrated', [
            'player' => $client->getUser(),
        ])), $this->clients);
    }

    public function addEnemy(Enemy $enemy): Promise
    {
        $this->enemy = $enemy;

        return $this->webSocket->sendToClients(new Render($this->template->render('/movement/enemy-entered', [
            'enemy' => $enemy,
        ])), $this->clients);
    }

    public function killEnemy(Enemy $enemy): Promise
    {
        return call(function () use ($enemy) {
            yield $this->webSocket->sendToClients(new Render($this->template->render('/battle/enemy-deSpawned', [
                'enemy' => $enemy,
            ])), $this->clients);

            $this->enemy = null;
        });
    }

    public function getEnemy(): ?Enemy
    {
        return $this->enemy;
    }

    public function getNpc(): ?Npc
    {
        return $this->npc;
    }

    public function getClients(): Clients
    {
        return $this->clients;
    }
}
