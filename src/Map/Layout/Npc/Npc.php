<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Npc;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;

abstract class Npc
{
    /** @var string */
    private $description;

    /** @var Template */
    protected $template;

    /** @var Position */
    private $position;

    public function __construct(string $description, Template $template, Position $position)
    {
        $this->description = $description;
        $this->template    = $template;
        $this->position    = $position;
    }

    abstract public function getOnEntranceMessage(Client $client): ?string;

    abstract public function canRunQuestCommand(Client $client): bool;

    abstract public function runQuestCommand(Client $client): ?string;

    abstract public function canRunGiveCommand(Client $client): bool;

    abstract public function runGiveCommand(Client $client, WebSocket $webSocket): Promise;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }
}
