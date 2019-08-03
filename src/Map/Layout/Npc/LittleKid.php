<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Npc;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Map\Layout\Quest\SorcerersMagicWand;
use PeeHaa\AerysRealmII\Map\Layout\Quest\TraitTeacher;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;

class LittleKid extends Npc
{
    public function __construct(Template $template, Position $position)
    {
        parent::__construct('A little kid', $template, $position);
    }

    public function getOnEntranceMessage(Client $client): ?string
    {
        $sorcerersMagicWandMessage = $this->getSorcerersMagicWandEntranceMessages($client);

        if ($sorcerersMagicWandMessage) {
            return $sorcerersMagicWandMessage;
        }

        return $this->getTraitTeacherEntranceMessage($client);
    }

    private function getSorcerersMagicWandEntranceMessages(Client $client): ?string
    {
        $quest = $client->getUser()->getQuest(SorcerersMagicWand::class);

        if ($quest && $quest->isFinished()) {
            return null;
        }

        if (!$quest || $quest->getCurrentStep() === 2) {
            return $this->template->render('/npc/little-kid/directions-to-sorcerers-son', [
                'npc'          => $this,
                'player'       => $client->getUser(),
                'sorcerersSon' => new SorcerersSon($this->template, $this->getPosition()),
            ]);
        }

        return null;
    }

    private function getTraitTeacherEntranceMessage(Client $client): ?string
    {
        $quest = $client->getUser()->getQuest(TraitTeacher::class);

        if ($quest && $quest->getCurrentStep() === 1) {
            $quest->proceed();

            return $this->template->render('/quest/trait-teacher/info-about-deflection-trait', [
                'npc'    => $this,
                'player' => $client->getUser(),
                'oldMan' => new OldMan($this->template, $this->getPosition()),
            ]);
        }

        if ($quest && $quest->getCurrentStep() === 6) {
            return $this->template->render('/quest/trait-teacher/want-to-learn-deflection-trait', [
                'npc'         => $this,
                'player'      => $client->getUser(),
                'sorcerer'    => new Sorcerer($this->template, $this->getPosition()),
                'animalTamer' => new AnimalTamer($this->template, $this->getPosition()),
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
        return false;
    }

    public function runGiveCommand(Client $client, WebSocket $webSocket): Promise
    {
        return new Success();
    }
}
