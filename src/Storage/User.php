<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Storage;

use Amp\Postgres\Link;
use Amp\Postgres\PgSqlStatement;
use Amp\Postgres\ResultSet;
use Amp\Promise;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\User\User as Entity;
use PeeHaa\AerysRealmII\Request\Request;
use PeeHaa\AerysRealmII\Storage\Item as ItemStorage;
use PeeHaa\AerysRealmII\Storage\Quest as QuestStorage;
use function Amp\call;
use function Amp\ParallelFunctions\parallel;

class User
{
    /** @var Link */
    private $dbConnection;

    /** @var Ladder */
    private $ladder;

    /** @var QuestStorage */
    private $questStorage;

    /** @var ItemStorage */
    private $itemStorage;

    public function __construct(
        Link $dbConnection,
        Ladder $ladder,
        QuestStorage $questStorage,
        ItemStorage $itemStorage
    ) {
        $this->dbConnection = $dbConnection;
        $this->ladder       = $ladder;
        $this->questStorage = $questStorage;
        $this->itemStorage  = $itemStorage;
    }

    public function getByUsername(string $username): Promise
    {
        return call(function () use ($username) {
            $query = '
                SELECT users.id AS id, username, password, email, map, position_x, position_y, xp, admin,
                  quests.class_name AS quest_class_name, quests.current_step, quests.finished,
                  items.class_name AS item_class_name
                FROM users
                LEFT JOIN quests ON quests.user_id = users.id
                LEFT JOIN items ON items.user_id = users.id
                WHERE lower(username) = :username
            ';

            /** @var PgSqlStatement $statement */
            $statement = yield $this->dbConnection->prepare($query);

            /** @var ResultSet $result */
            $result = yield $statement->execute([
                'username' => strtolower($username),
            ]);

            if (!yield $result->advance()) {
                return null;
            }

            $userInformation = [];

            do {
                $userInformation[] = $result->getCurrent();
            } while (yield $result->advance());

            return Entity::fromRecordSet($userInformation, $this->ladder);
        });
    }

    public function createUser(Request $request): Promise
    {
        return call(function () use ($request) {
            $passwordHash = yield parallel(function () use ($request) {
                return password_hash($request->getParameterAtIndex(1), PASSWORD_DEFAULT);
            })();

            $query = '
                INSERT INTO users
                    (username, password, email)
                VALUES
                    (:username, :password, :email)
            ';

            /** @var PgSqlStatement $statement */
            $statement = yield $this->dbConnection->prepare($query);

            yield $statement->execute([
                'username' => $request->getParameterAtIndex(0),
                'password' => $passwordHash,
                'email'    => $request->getParameterAtIndex(2),
            ]);

            return yield $this->getByUsername($request->getParameterAtIndex(0));
        });
    }

    public function persist(Entity $user): Promise
    {
        return call(function () use ($user) {
            $query = '
                UPDATE users
                SET map = :map, position_x = :positionX, position_y = :positionY, xp = :xp
                WHERE id = :id
            ';

            /** @var PgSqlStatement $statement */
            $statement = yield $this->dbConnection->prepare($query);

            yield $statement->execute([
                'id'        => $user->getId(),
                'map'       => $user->getMapPosition()->getMapId(),
                'positionX' => $user->getMapPosition()->getPosition()->x(),
                'positionY' => $user->getMapPosition()->getPosition()->y(),
                'xp'        => $user->getExperiencePoints(),
            ]);

            yield $this->questStorage->persistUserQuests($user);
            yield $this->itemStorage->persistUserItems($user);
        });
    }
}
