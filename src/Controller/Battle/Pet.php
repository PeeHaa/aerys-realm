<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Battle;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\SmallCat;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;

class Pet
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
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/invalid-target-pet')));
        }

        if (get_class($enemy) !== SmallCat::class) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/invalid-target-pet')));
        }

        $client->getUser()->removeHitPoints(1);

        return $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/pet', [
            'enemy' => new SmallCat(-1),
        ])));
    }
}
