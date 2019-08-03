<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Navigation\Look;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class Look
{
    /** @var WebSocket */
    private $webSocket;

    /** @var Template */
    private $template;

    /** @var Engine */
    private $engine;

    public function __construct(WebSocket $webSocket, Template $template, Engine $engine)
    {
        $this->webSocket = $webSocket;
        $this->template  = $template;
        $this->engine    = $engine;
    }

    public function process(Client $client): Promise
    {
        return call(function () use ($client) {
            yield $this->webSocket->sendToClient($client, new Render($this->template->render('/navigation/look/look', [
                'tile'      => $this->engine->getTileClientIsOn($client),
                'northTile' => $this->engine->getTileOnMapPosition($client->getUser()->getMapPosition()->moveUp()),
                'eastTile'  => $this->engine->getTileOnMapPosition($client->getUser()->getMapPosition()->moveRight()),
                'southTile' => $this->engine->getTileOnMapPosition($client->getUser()->getMapPosition()->moveDown()),
                'westTile'  => $this->engine->getTileOnMapPosition($client->getUser()->getMapPosition()->moveLeft()),
                'npc'       => $this->engine->getNpcOnMapPosition($client->getUser()->getMapPosition()),
            ])));

            yield $this->processPlayers($client);

            yield $this->processEnemy($client);
        });
    }

    private function processPlayers(Client $client): Promise
    {
        $clients = $this->engine->getClientsOnMapPosition($client->getUser()->getMapPosition());

        if (count($clients) < 2) {
            return new Success();
        }

        $players = [];
        foreach ($clients as $clientOnTile) {
            if ($client->getId() === $clientOnTile->getId()) {
                continue;
            }

            $players[] = $this->template->render('/blocks/player', [
                'player' => $clientOnTile->getUser(),
            ]);
        }

        return $this->webSocket->sendToClient($client, new Render($this->template->render('/navigation/look/players', [
            'players' => $players,
        ])));
    }

    private function processEnemy(Client $client): Promise
    {
        if (null === $enemy = $this->engine->getEnemyOnMapPosition($client->getUser()->getMapPosition())) {
            return new Success();
        }

        return $this->webSocket->sendToClient($client, new Render($this->template->render('/navigation/look/enemy', [
            'enemy' => $enemy,
        ])));
    }
}
