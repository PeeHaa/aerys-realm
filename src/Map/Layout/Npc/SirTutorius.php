<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Npc;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\AttackDummy;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;

class SirTutorius extends Npc
{
    public function __construct(Template $template, Position $position)
    {
        parent::__construct('Sir Tutorius', $template, $position);
    }

    public function getOnEntranceMessage(Client $client): ?string
    {
        if ($client->getUser()->getExperiencePoints() > 0) {
            return null;
        }

        return $this->template->render('/npc/sir-tutorius/welcome', [
            'npc'    => $this,
            'player' => $client->getUser(),
            'enemy'  => new AttackDummy(-1),
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
