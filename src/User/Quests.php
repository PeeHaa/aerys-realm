<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User;

use PeeHaa\AerysRealmII\Map\Layout\Quest\Quest;

class Quests implements \Iterator
{
    private $quests = [];

    public function __construct(Quest ...$quests)
    {
        foreach ($quests as $quest) {
            $this->add($quest);
        }
    }

    public static function fromUserRecordSet(array $recordSet): self
    {
        $quests = new self();

        foreach ($recordSet as $record) {
            if ($record['quest_class_name'] === null) {
                continue;
            }

            if ($quests->getQuest($record['quest_class_name'])) {
                continue;
            }

            $quests->add(Quest::fromUserRecord($record));
        }

        return $quests;
    }

    public function add(Quest $quest): void
    {
        $this->quests[get_class($quest)] = $quest;
    }

    public function getQuest(string $questName): ?Quest
    {
        if (!isset($this->quests[$questName])) {
            return null;
        }

        return $this->quests[$questName];
    }

    public function current(): Quest
    {
        return current($this->quests);
    }

    public function next()
    {
        next($this->quests);
    }

    public function key(): ?string
    {
        return key($this->quests);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind()
    {
        reset($this->quests);
    }

    public function count(): int
    {
        return count($this->quests);
    }
}
