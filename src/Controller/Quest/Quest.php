<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Quest;

use function Amp\call;
use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\WebSocket;

class Quest
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
        if (null === $npc = $this->engine->getNpcOnMapPosition($client->getUser()->getMapPosition())) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/quest/invalid-target')));
        }

        if (!$npc->canRunQuestCommand($client)) {
            return $this->webSocket->sendToClient($client, new Render($this->template->render('/quest/unavailable')));
        }

        return call(function () use ($client, $npc, $ladder) {
            $message = $npc->runQuestCommand($client);

            yield $this->webSocket->sendToClient($client, new Render($message));

            $nextLevel = $ladder->getNextLevel($client->getUser()->getLevel());

            if ($client->getUser()->getExperiencePoints() < $nextLevel->getExperiencePoints()) {
                return;
            }

            $client->getUser()->setLevel($nextLevel);

            return $this->webSocket->sendToClient($client, new Render($this->template->render('/stats/level-up')));
        });
    }
}
