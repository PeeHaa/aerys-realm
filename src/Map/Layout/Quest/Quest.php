<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Quest;

abstract class Quest
{
    private $currentStep = 1;

    private $finished = false;

    public static function fromUserRecord(array $record)
    {
        $questName = $record['quest_class_name'];

        $quest = new $questName();

        $quest->currentStep = $record['current_step'];
        $quest->finished    = $record['finished'];

        return $quest;
    }

    public function getCurrentStep(): int
    {
        return $this->currentStep;
    }

    public function proceed(): void
    {
        $this->currentStep++;
    }

    public function finish(): void
    {
        $this->finished = true;
    }

    public function isFinished(): bool
    {
        return $this->finished;
    }
}
