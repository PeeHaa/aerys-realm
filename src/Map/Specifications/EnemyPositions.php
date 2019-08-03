<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Specifications;

use PeeHaa\AerysRealmII\ValueObject\Position;

class EnemyPositions
{
    /** @var Enemy */
    private $enemy;

    /** @var Position[] */
    private $positions;

    public function __construct(Enemy $enemy, Position ...$positions)
    {
        $this->enemy     = $enemy;
        $this->positions = $positions;
    }

    public function getEnemy(): Enemy
    {
        return $this->enemy;
    }

    /**
     * @return Position[]
     */
    public function getPositions(): array
    {
        return $this->positions;
    }
}
