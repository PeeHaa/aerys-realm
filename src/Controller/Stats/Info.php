<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Stats;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\WebSocket;

class Info
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

    public function process(Client $client, Ladder $ladder): Promise
    {
        return $this->webSocket->sendToClient($client, new Render($this->template->render('/stats/info', [
            'player'     => $client->getUser(),
            'level'      => $client->getUser()->getLevel(),
            'nextLevel'  => $ladder->getNextLevel($client->getUser()->getLevel()),
            'lineLength' => mb_strlen($client->getUser()->getLevel()->getDescription()),
        ])));
    }
}
