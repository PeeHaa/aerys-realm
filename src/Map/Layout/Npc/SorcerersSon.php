<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Npc;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Map\Layout\Item\MagicWand;
use PeeHaa\AerysRealmII\Map\Layout\Quest\SorcerersMagicWand;
use PeeHaa\AerysRealmII\Map\Layout\Tile\MagicTower;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;

class SorcerersSon extends Npc
{
    public function __construct(Template $template, Position $position)
    {
        parent::__construct('The Sorcerer\'s Son', $template, $position);
    }

    public function getOnEntranceMessage(Client $client): ?string
    {
        $quest = $client->getUser()->getQuest(SorcerersMagicWand::class);

        if ($quest && ($quest->isFinished() || $quest->getCurrentStep() === 1)) {
            return null;
        }

        if (!$quest) {
            return $this->template->render('/npc/sorcerers-son/good-you-are-here', [
                'npc'    => $this,
                'player' => $client->getUser(),
            ]);
        }

        $quest->finish();

        $client->getUser()->addExperiencePoints(10);

        return $this->template->render('/quest/sorcerers-magic-wand/finish', [
            'npc'        => $this,
            'magicWand'  => new MagicWand(),
        ]);
    }

    public function canRunQuestCommand(Client $client): bool
    {
        $quest = $client->getUser()->getQuest(SorcerersMagicWand::class);

        if (!$quest) {
            return true;
        }

        return false;
    }

    public function runQuestCommand(Client $client): string
    {
        $quest = $client->getUser()->getQuest(SorcerersMagicWand::class);

        if (!$quest) {
            $client->getUser()->startQuest(SorcerersMagicWand::class);
            $client->getUser()->addItem(new MagicWand());

            return $this->template->render('/quest/sorcerers-magic-wand/start', [
                'npc'        => $this,
                'player'     => $client->getUser(),
                'magicTower' => new MagicTower($this->getPosition()),
                'oldMan'     => new OldMan($this->template, $this->getPosition()),
                'magicWand'  => new MagicWand(),
            ]);
        }
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
