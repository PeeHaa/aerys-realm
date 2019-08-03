<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Stats;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Request\Request;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\WebSocket;

class InfoPlayer
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

    public function process(Client $client, Request $request, Ladder $ladder): Promise
    {
        $clients = $this->engine->getClientsOnMapPosition($client->getUser()->getMapPosition());

        $clients = $clients->filter(function (Client $target) use ($request) {
            return $target->getUser()->getUsername() === $request->getParameterAtIndex(0);
        });

        if (!$clients->count()) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/stats/no-player', [
                'player' => $request->getParameterAtIndex(0),
            ])));
        }

        $user = $clients->current()->getUser();

        return $this->webSocket->sendToClient($client, new Render($this->template->render('/stats/info', [
            'player'     => $user,
            'level'      => $user->getLevel(),
            'nextLevel'  => $ladder->getNextLevel($user->getLevel()),
            'lineLength' => mb_strlen($user->getLevel()->getDescription()),
        ])));
    }
}
