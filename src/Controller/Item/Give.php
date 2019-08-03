<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Item;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;

class Give
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
        $npc = $this->engine->getNpcOnMapPosition($client->getUser()->getMapPosition());

        if (!$npc) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/items/give/no-npc')));
        }

        if (!count($client->getUser()->getItems())) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/items/give/empty-inventory')));
        }

        if (!$npc->canRunGiveCommand($client)) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/items/give/unavailable', [
                'npc' => $npc,
            ])));
        }

        return $npc->runGiveCommand($client, $this->webSocket);
    }
}
