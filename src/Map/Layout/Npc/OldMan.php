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

class OldMan extends Npc
{
    public function __construct(Template $template, Position $position)
    {
        parent::__construct('An old man', $template, $position);
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
            return $this->template->render('/npc/old-man/directions-to-sorcerers-son', [
                'npc'          => $this,
                'player'       => $client->getUser(),
                'sorcerersSon' => new SorcerersSon($this->template, $this->getPosition()),
            ]);
        }

        if ($quest && $quest->getCurrentStep() === 1) {
            return $this->template->render('/npc/old-man/directions-to-sorcerer', [
                'npc'      => $this,
                'player'   => $client->getUser(),
                'sorcerer' => new Sorcerer($this->template, $this->getPosition()),
            ]);
        }

        return null;
    }

    private function getTraitTeacherEntranceMessage(Client $client): ?string
    {
        $quest = $client->getUser()->getQuest(TraitTeacher::class);

        if ($quest && $quest->isFinished()) {
            return null;
        }

        if (!$quest) {
            return $this->template->render('/npc/old-man/want-to-start-trait-teacher', [
                'npc'      => $this,
                'player'   => $client->getUser(),
                'sorcerer' => new Sorcerer($this->template, $this->getPosition()),
            ]);
        }

        if ($quest && $quest->getCurrentStep() === 2) {
            $quest->proceed();

            return $this->template->render('/quest/trait-teacher/go-to-sorcerer', [
                'npc'       => $this,
                'player'    => $client->getUser(),
                'littleKid' => new LittleKid($this->template, $this->getPosition()),
                'sorcerer'  => new Sorcerer($this->template, $this->getPosition()),
            ]);
        }

        if ($quest && $quest->getCurrentStep() === 5) {
            $quest->proceed();

            return $this->template->render('/quest/trait-teacher/pick-a-trait', [
                'npc'         => $this,
                'player'      => $client->getUser(),
                'littleKid'   => new LittleKid($this->template, $this->getPosition()),
                'sorcerer'    => new Sorcerer($this->template, $this->getPosition()),
                'animalTamer' => new AnimalTamer($this->template, $this->getPosition()),
            ]);
        }

        return null;
    }

    public function canRunQuestCommand(Client $client): bool
    {
        $quest = $client->getUser()->getQuest(SorcerersMagicWand::class);

        if (!$quest || !$quest->isFinished()) {
            return false;
        }

        $quest = $client->getUser()->getQuest(TraitTeacher::class);

        if (!$quest) {
            return true;
        }

        return false;
    }

    public function runQuestCommand(Client $client): ?string
    {
        $client->getUser()->startQuest(TraitTeacher::class);

        return $this->template->render('/quest/trait-teacher/start', [
            'npc'       => $this,
            'player'    => $client->getUser(),
            'littleKid' => new LittleKid($this->template, $this->getPosition()),
        ]);
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
