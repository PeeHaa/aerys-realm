<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Storage;

use Amp\Postgres\Link;
use Amp\Postgres\PgSqlStatement;
use Amp\Promise;
use Amp\Sql\ResultSet;
use PeeHaa\AerysRealmII\Map\Layout\Quest\Quest as Entity;
use PeeHaa\AerysRealmII\User\User;
use function Amp\call;

class Quest
{
    private $dbConnection;

    public function __construct(Link $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function persistUserQuests(User $user): Promise
    {
        $promises = [];

        foreach ($user->getQuests() as $quest) {
            $promises[] = $this->persistQuest($user, $quest);
        }

        return Promise\all($promises);
    }

    private function persistQuest(User $user, Entity $quest): Promise
    {
        return call(function () use ($user, $quest) {
            if (yield $this->questExists($user, $quest)) {
                yield $this->updateQuest($user, $quest);

                return;
            }

            yield $this->createQuest($user, $quest);
        });
    }

    private function questExists(User $user, Entity $quest): Promise
    {
        return call(function () use ($user, $quest) {
            $query = '
                SELECT COUNT(id) AS count
                FROM quests
                WHERE user_id = :userId
                  AND class_name = :className
            ';

            /** @var PgSqlStatement $statement */
            $statement = yield $this->dbConnection->prepare($query);

            /** @var ResultSet $result */
            $result = yield $statement->execute([
                'userId'    => $user->getId(),
                'className' => get_class($quest),
            ]);

            yield $result->advance();

            return (bool) $result->getCurrent()['count'];
        });
    }

    private function updateQuest(User $user, Entity $quest): Promise
    {
        return call(function () use ($user, $quest) {
            $query = '
                UPDATE quests
                SET current_step = :currentStep, finished = :finished
                WHERE user_id = :userId
                  AND class_name = :className
            ';

            /** @var PgSqlStatement $statement */
            $statement = yield $this->dbConnection->prepare($query);

            yield $statement->execute([
                'userId'      => $user->getId(),
                'className'   => get_class($quest),
                'currentStep' => $quest->getCurrentStep(),
                'finished'    => $quest->isFinished(),
            ]);
        });
    }

    private function createQuest(User $user, Entity $quest): Promise
    {
        return call(function () use ($user, $quest) {
            $query = '
                INSERT INTO quests
                  (user_id, class_name, current_step, finished)
                VALUES
                  (:userId, :className, :currentStep, :finished)
            ';

            /** @var PgSqlStatement $statement */
            $statement = yield $this->dbConnection->prepare($query);

            yield $statement->execute([
                'userId'      => $user->getId(),
                'className'   => get_class($quest),
                'currentStep' => $quest->getCurrentStep(),
                'finished'    => $quest->isFinished(),
            ]);
        });
    }
}
