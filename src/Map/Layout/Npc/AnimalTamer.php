<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Npc;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Map\Layout\Quest\TraitTeacher;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;

class AnimalTamer extends Npc
{
    public function __construct(Template $template, Position $position)
    {
        parent::__construct('An animal tamer', $template, $position);
    }

    public function getOnEntranceMessage(Client $client): ?string
    {
        $quest = $client->getUser()->getQuest(TraitTeacher::class);

        if ($quest && $quest->getCurrentStep() === 4) {
            $quest->proceed();

            return $this->template->render('/quest/trait-teacher/info-about-taming-trait', [
                'npc'    => $this,
                'player' => $client->getUser(),
                'oldMan' => new OldMan($this->template, $this->getPosition()),
            ]);
        }

        if ($quest && $quest->getCurrentStep() === 6) {
            return $this->template->render('/quest/trait-teacher/want-to-learn-taming-trait', [
                'npc'      => $this,
                'player'    => $client->getUser(),
                'sorcerer'  => new Sorcerer($this->template, $this->getPosition()),
                'littleKid' => new LittleKid($this->template, $this->getPosition()),
            ]);
        }

        return null;
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
        return true;
    }

    public function runGiveCommand(Client $client, WebSocket $webSocket): Promise
    {
        return new Success();
    }
}
