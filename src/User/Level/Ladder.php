<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User\Level;

class Ladder
{
    private $levels;

    public function __construct(Level ...$levels)
    {
        $this->levels = $levels;
    }

    public function getLevelBasedOnExperiencePoints(int $userExperiencePoints): Level
    {
        $userLevel = $this->levels[0];

        foreach ($this->levels as $level) {
            if ($level->getExperiencePoints() > $userExperiencePoints) {
                break;
            }

            $userLevel = $level;
        }

        return $userLevel;
    }

    public function getNextLevel(Level $currentLevel): Level
    {
        foreach ($this->levels as $level) {
            if ($level->getExperiencePoints() <= $currentLevel->getExperiencePoints()) {
                continue;
            }

            return $level;
        }
    }
}
