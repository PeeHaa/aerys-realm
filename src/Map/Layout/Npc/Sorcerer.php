<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Npc;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Map\Layout\Item\MagicWand;
use PeeHaa\AerysRealmII\Map\Layout\Quest\SorcerersMagicWand;
use PeeHaa\AerysRealmII\Map\Layout\Quest\TraitTeacher;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class Sorcerer extends Npc
{
    public function __construct(Template $template, Position $position)
    {
        parent::__construct('A Sorcerer', $template, $position);
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

        if (!$quest || $quest->getCurrentStep() !== 1) {
            return null;
        }

        return $this->template->render('/npc/sorcerer/magic-wand', [
            'npc'          => $this,
            'player'       => $client->getUser(),
            'magicWand'    => new MagicWand(),
            'sorcerersSon' => new SorcerersSon($this->template, $this->getPosition()),
        ]);
    }

    private function getTraitTeacherEntranceMessage(Client $client): ?string
    {
        $quest = $client->getUser()->getQuest(TraitTeacher::class);

        if ($quest && $quest->getCurrentStep() === 3) {
            $quest->proceed();

            return $this->template->render('/quest/trait-teacher/info-about-fireball-trait', [
                'npc'         => $this,
                'player'      => $client->getUser(),
                'animalTamer' => new AnimalTamer($this->template, $this->getPosition()),
            ]);
        }

        if ($quest && $quest->getCurrentStep() === 6) {
            return $this->template->render('/quest/trait-teacher/want-to-learn-fireball-spell', [
                'npc'         => $this,
                'player'      => $client->getUser(),
                'animalTamer' => new AnimalTamer($this->template, $this->getPosition()),
                'littleKid'   => new LittleKid($this->template, $this->getPosition()),
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
        if (!$client->getUser()->getItems()->getItem(MagicWand::class)) {
            return $webSocket->sendToClient($client, new Render($this->template->render('/items/give/item-not-available', [
                'npc'    => $this,
            ])));
        }

        $quest = $client->getUser()->getQuest(SorcerersMagicWand::class);

        $client->getUser()->removeItem(MagicWand::class);

        $quest->proceed();

        return call(function () use ($client, $webSocket) {
            yield $webSocket->sendToClient($client, new Render($this->template->render('/quest/sorcerers-magic-wand/return', [
                'npc'       => $this,
                'player'    => $client->getUser(),
                'magicWand' => new MagicWand(),
            ])));
        });
    }
}
