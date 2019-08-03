<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Navigation\Walk;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class South
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
        $tile = $this->engine->getTileOnMapPosition($client->getUser()->getMapPosition()->moveDown());

        if (!$tile->isAccessible()) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/navigation/walk/inaccessible', [
                'direction' => 'south',
                'tile'      => $tile,
            ])));
        }

        if ($client->getUser()->isAttacking()) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/navigation/walk/attacking')));
        }

        return call(function () use ($client, $tile) {
            yield $this->engine->moveClient($client, $client->getUser()->getMapPosition()->moveDown(), 'south');

            yield $this->webSocket->sendToClient($client, new Render($this->template->render('/navigation/walk/direction', [
                'direction' => 'south',
                'tile'      => $tile,
            ])));

            yield $this->processEnemy($client);

            yield $this->processNpc($client);
        });
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

    private function processNpc(Client $client): Promise
    {
        if (null === $npc = $this->engine->getNpcOnMapPosition($client->getUser()->getMapPosition())) {
            return new Success();
        }

        $message = $npc->getOnEntranceMessage($client);

        if (!$message) {
            return new Success();
        }

        return $this->webSocket->sendToClient($client, new Render($message));
    }
}
