<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Storage;

use Amp\Postgres\Link;
use Amp\Postgres\PgSqlStatement;
use Amp\Promise;
use PeeHaa\AerysRealmII\Map\Layout\Item\Item as Entity;
use PeeHaa\AerysRealmII\User\User;
use function Amp\call;

class Item
{
    private $dbConnection;

    public function __construct(Link $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function persistUserItems(User $user): Promise
    {
        return call(function () use ($user) {
            yield $this->clearItems($user);

            $promises = [];

            foreach ($user->getItems() as $item) {
                $promises[] = $this->createItem($user, $item);
            }

            return Promise\all($promises);
        });
    }

    private function clearItems(User $user): Promise
    {
        return call(function () use ($user) {
            $query = '
                DELETE FROM items
                WHERE user_id = :userId
            ';

            /** @var PgSqlStatement $statement */
            $statement = yield $this->dbConnection->prepare($query);

            yield $statement->execute([
                'userId'    => $user->getId(),
            ]);
        });
    }

    private function createItem(User $user, Entity $item): Promise
    {
        return call(function () use ($user, $item) {
            $query = '
                INSERT INTO items
                  (user_id, class_name)
                VALUES
                  (:userId, :className)
            ';

            /** @var PgSqlStatement $statement */
            $statement = yield $this->dbConnection->prepare($query);

            yield $statement->execute([
                'userId'      => $user->getId(),
                'className'   => get_class($item),
            ]);
        });
    }
}
