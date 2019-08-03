<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Item;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;

class Inventory
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
        $lineLength = 0;

        foreach ($client->getUser()->getItems() as $item) {
            $itemLength = mb_strlen($item->getName()) + mb_strlen($item->getDescription()) + 3;

            if ($itemLength > $lineLength) {
                $lineLength = $itemLength;
            }
        }

        if (!count($client->getUser()->getItems())) {
            $lineLength = 23;
        }

        return $this->webSocket->sendToClient($client, new Render($this->template->render('/items/inventory', [
            'items'      => $client->getUser()->getItems(),
            'lineLength' => $lineLength,
        ])));
    }
}
