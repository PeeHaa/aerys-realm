<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Npc;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;

class GateKeeper extends Npc
{
    public function __construct(Template $template, Position $position)
    {
        parent::__construct('The Gate Keeper', $template, $position);
    }

    public function getOnEntranceMessage(Client $client): ?string
    {
        if ($client->getUser()->getLevel()->getNumeric() > 3) {
            return null;
        }

        return $this->template->render('/npc/gate-keeper/warning', [
            'npc'    => $this,
            'player' => $client->getUser(),
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
