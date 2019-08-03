<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Npc;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;

class Introdor extends Npc
{
    public function __construct(Template $template, Position $position)
    {
        parent::__construct('Introdor', $template, $position);
    }

    public function getOnEntranceMessage(Client $client): ?string
    {
        return $this->template->render('/npc/introdor/intro', [
            'npc'          => $this,
            'player'       => $client->getUser(),
            'sorcerersSon' => new SorcerersSon($this->template, $this->getPosition())
        ]);
    }

    public function canRunQuestCommand(Client $client): bool
    {
        return false;
    }

    public function runQuestCommand(Client $client): ?string
    {
        return null;
    }

    public function canRunGiveCommand(Client $client): bool
    {
        return false;
    }

    public function runGiveCommand(Client $client, WebSocket $webSocket): Promise
    {
        return new Success();
    }
}
