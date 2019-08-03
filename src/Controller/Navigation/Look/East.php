<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Navigation\Look;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;

class East
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
        $tile = $this->engine->getTileOnMapPosition($client->getUser()->getMapPosition()->moveRight());

        return $this->webSocket->sendToClient($client, new Render($this->template->render('/navigation/look/direction', [
            'tile'      => $tile,
            'direction' => 'east',
        ])));
    }
}
