<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Battle;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\Enemy;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class Attack
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
        if (null === $enemy = $this->engine->getEnemyOnMapPosition($client->getUser()->getMapPosition())) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/invalid-target')));
        }

        if ($client->getUser()->isAttacking()) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/already-attacking')));
        }

        return call(function () use ($client, $enemy) {
            yield $this->processEnemy($client, $enemy);

            yield $this->engine->attack($client);
        });
    }

    private function processEnemy(Client $client, Enemy $enemy): Promise
    {
        return $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/attack', [
            'enemy' => $enemy,
        ])));
    }
}
