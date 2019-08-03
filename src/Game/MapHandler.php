<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Game;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Clients;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\Enemy;
use PeeHaa\AerysRealmII\Map\Layout\Map;
use PeeHaa\AerysRealmII\Map\Layout\Npc\Npc;
use PeeHaa\AerysRealmII\Map\Layout\Tile\Tile;
use PeeHaa\AerysRealmII\Map\Specifications\EnemyPositions;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class MapHandler
{
    /** @var WebSocket */
    private $webSocket;

    /** @var Template */
    private $template;

    /** @var Map */
    private $map;

    /** @var TileHandler[] */
    private $tileHandlers;

    /** @var Ladder */
    private $ladder;

    private $enemies = [];

    /** @var Attack[] */
    private $attacks = [];

    public function __construct(
        WebSocket $webSocket,
        Template $template,
        Map $map,
        Ladder $ladder,
        TileHandler ...$tileHandlers
    ) {
        $this->webSocket = $webSocket;
        $this->template  = $template;
        $this->map       = $map;
        $this->ladder    = $ladder;

        foreach ($tileHandlers as $tileHandler) {
            $this->tileHandlers[(string) $tileHandler->getPosition()] = $tileHandler;
        }

        $this->initializeEnemies();
        $this->initializeNpcs();
    }

    private function initializeEnemies(): void
    {
        foreach ($this->map->getEnemies() as $enemyType) {
            $this->enemies[$enemyType->getEnemy()->getId()] = [];
        }
    }

    private function initializeNpcs(): void
    {
        foreach ($this->map->getNpcs() as $npc) {
            $this->tileHandlers[(string) $npc->getPosition()]->placeNpc($npc);
        }
    }

    public function spawnClient(Client $client): Promise
    {
        return call(function () use ($client) {
            yield $this->tileHandlers[(string) $client->getUser()->getMapPosition()->getPosition()]->killClient($client);

            $newPosition = $client->getUser()->getMapPosition()->moveToPosition($this->map->getSpawnPoint());

            $client->getUser()->moveToPosition($newPosition);

            yield $this->tileHandlers[(string) $newPosition->getPosition()]->spawnClient($client);
        });
    }

    public function tick(): Promise
    {
        return call(function () {
            yield $this->placeNewEnemiesWhenNeeded();

            foreach ($this->attacks as $key => $attack) {
                if (!$attack->isActive()) {
                    unset($this->attacks[$key]);

                    continue;
                }

                yield $attack->tick();
            }
        });
    }

    private function placeNewEnemiesWhenNeeded(): Promise
    {
        return call(function () {
            foreach ($this->map->getEnemies() as $enemyType) {
                yield $this->placeNewEnemyTypeWhenNeeded($enemyType);
            }
        });
    }

    private function placeNewEnemyTypeWhenNeeded(EnemyPositions $enemyType): Promise
    {
        $minimumNumberOfExtraEnemiesToPlace = $enemyType->getEnemy()->getMinimum() - count($this->enemies[$enemyType->getEnemy()->getId()]);
        $maximumNumberOfExtraEnemiesToPlace = $enemyType->getEnemy()->getMaximum() - count($this->enemies[$enemyType->getEnemy()->getId()]);

        if ($minimumNumberOfExtraEnemiesToPlace < 1) {
            return new Success();
        }

        $numberOfExtraEnemiesToPlace = random_int($minimumNumberOfExtraEnemiesToPlace, $maximumNumberOfExtraEnemiesToPlace);

        return call(function () use ($enemyType, $numberOfExtraEnemiesToPlace) {
            while ($numberOfExtraEnemiesToPlace) {
                yield $this->placeNewEnemyType($enemyType);

                $numberOfExtraEnemiesToPlace--;
            }
        });
    }

    private function placeNewEnemyType(EnemyPositions $enemyType): Promise
    {
        return call(function () use ($enemyType) {
            $availablePositions = array_values(array_filter($enemyType->getPositions(), function (Position $position) use ($enemyType) {
                return !in_array((string) $position, $this->enemies[$enemyType->getEnemy()->getId()]);
            }));

            if ($availablePositions < 1) {
                return;
            }

            $position = $availablePositions[random_int(0, count($availablePositions) - 1)];

            $this->enemies[$enemyType->getEnemy()->getId()][] = (string) $position;

            $enemyClassName = $enemyType->getEnemy()->className();

            yield $this->tileHandlers[(string) $position]->addEnemy(new $enemyClassName($enemyType->getEnemy()->getId()));
        });
    }

    public function killEnemy(Enemy $enemy, Position $position): Promise
    {
        $indexToBeRemoved = array_search((string) $position, $this->enemies[$enemy->getId()], true);

        unset($this->enemies[$enemy->getId()][$indexToBeRemoved]);

        $this->tileHandlers[(string) $position]->killEnemy($enemy);

        return $this->removeAttack($position);
    }

    public function removeAttack(Position $position): Promise
    {
        unset($this->attacks[(string) $position]);

        return new Success();
    }

    public function getId(): string
    {
        return $this->map->getId();
    }

    public function addClient(Client $client): Promise
    {
        return $this->tileHandlers[(string) $client->getUser()->getMapPosition()->getPosition()]->addClient($client);
    }

    public function removeClient(Client $client, ?string $direction = null): Promise
    {
        return $this->tileHandlers[(string) $client->getUser()->getMapPosition()->getPosition()]->removeClient($client, $direction);
    }

    public function getTileClientIsOn(Client $client): Tile
    {
        return $this->tileHandlers[(string) $client->getUser()->getMapPosition()->getPosition()]->getTile();
    }

    public function getTileOnPosition(Position $position): Tile
    {
        return $this->tileHandlers[(string) $position]->getTile();
    }

    public function getEnemyOnPosition(Position $position): ?Enemy
    {
        return $this->tileHandlers[(string) $position]->getEnemy();
    }

    public function getNpcOnPosition(Position $position): ?Npc
    {
        return $this->tileHandlers[(string) $position]->getNpc();
    }

    public function getClientsOnPosition(Position $position): Clients
    {
        return $this->tileHandlers[(string) $position]->getClients();
    }

    public function attack(Client $client): Promise
    {
        $position = $client->getUser()->getMapPosition()->getPosition();

        $client->getUser()->startAttack();

        if (isset($this->attacks[(string) $position])) {
            return $this->attacks[(string) $position]->addClient($client);
        }

        $this->attacks[(string) $position] = new Attack(
            $this->webSocket,
            $this->template,
            $this->tileHandlers[(string) $position],
            $this->getEnemyOnPosition($position),
            (new Clients())->add($client),
            $this,
            $position,
            $this->ladder
        );

        return new Success();
    }
}
