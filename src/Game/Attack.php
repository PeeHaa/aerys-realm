<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Game;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Clients;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\Enemy;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\ValueObject\Position;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class Attack
{
    /** @var WebSocket */
    private $webSocket;

    /** @var Template */
    private $template;

    /** @var TileHandler */
    private $tileHandler;

    /** @var Enemy */
    private $enemy;

    /** @var Clients */
    private $clients;

    /** @var MapHandler */
    private $mapHandler;

    /** @var Position */
    private $position;

    /** @var Ladder */
    private $ladder;

    /** @var bool */
    private $active = true;

    public function __construct(
        WebSocket $webSocket,
        Template $template,
        TileHandler $tileHandler,
        Enemy $enemy,
        Clients $clients,
        MapHandler $mapHandler,
        Position $position,
        Ladder $ladder
    ) {
        $this->webSocket   = $webSocket;
        $this->template    = $template;
        $this->tileHandler = $tileHandler;
        $this->enemy       = $enemy;
        $this->clients     = $clients;
        $this->mapHandler  = $mapHandler;
        $this->position    = $position;
        $this->ladder      = $ladder;
    }

    public function addClient(Client $client): Promise
    {
        $this->clients->add($client);

        return $this->webSocket->sendToClients(new Render($this->template->render('/battle/player-joins', [
            'player' => $client->getUser(),
            'enemy'  => $this->enemy,
        ])), $this->clients->filter(function (Client $targetClient) use ($client) {
            return $targetClient->getId() !== $client->getId();
        }));
    }

    public function tick(): Promise
    {
        return call(function () {
            yield $this->processClientAttacks();
            yield $this->processEnemyAttack();
        });
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    private function processClientAttacks(): Promise
    {
        return call(function () {
            foreach ($this->clients as $client) {
                yield $this->processClientAttack($client);
            }
        });
    }

    private function processClientAttack(Client $client): Promise
    {
        if (!$this->active) {
            return new Success();
        }

        if (!$this->enemy->doesAttackHit($client->getUser())) {
            return $this->processMissedPlayerAttack($client);
        }

        return $this->processHitPlayerAttack($client);
    }

    private function processMissedPlayerAttack(Client $client): Promise
    {
        return call(function () use ($client) {
            yield $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/player-miss-self', [
                'enemy' => $this->enemy,
            ])));

            yield $this->processMissedPlayerAttackForOtherClients($client);
        });
    }

    private function processMissedPlayerAttackForOtherClients(Client $attackingClient): Promise
    {
        return $this->webSocket->sendToClients(new Render($this->template->render('/battle/player-miss-other', [
            'player' => $attackingClient->getUser(),
            'enemy'  => $this->enemy,
        ])), $this->clients->filter(function (Client $client) use ($attackingClient) {
            return $client->getId() !== $attackingClient->getId();
        }));
    }

    private function processHitPlayerAttack(Client $client): Promise
    {
        return call(function () use ($client) {
            $damage = $this->enemy->registerAttack($client->getUser());

            yield $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/player-hit-self', [
                'enemy'  => $this->enemy,
                'damage' => $damage,
            ])));

            yield $this->processHitPlayerAttackForOtherClients($client, $damage);

            if ($this->enemy->getHitPoints() <= 0) {
                $this->active = false;

                yield $this->mapHandler->killEnemy($this->enemy, $this->position);

                yield $this->processPlayerKilledEnemy($client);

                $this->clients->each(function (Client $client) {
                    $client->getUser()->stopAttack();
                });
            }
        });
    }

    private function processHitPlayerAttackForOtherClients(Client $attackingClient, int $damage): Promise
    {
        return $this->webSocket->sendToClients(new Render($this->template->render('/battle/player-hit-other', [
            'player' => $attackingClient->getUser(),
            'enemy'  => $this->enemy,
            'damage' => $damage,
        ])), $this->clients->filter(function (Client $client) use ($attackingClient) {
            return $client->getId() !== $attackingClient->getId();
        }));
    }

    private function processPlayerKilledEnemy(Client $attackingClient): Promise
    {
        return call(function () use ($attackingClient) {
            yield $this->webSocket->sendToClient($attackingClient, new Render($this->template->render('/battle/player-killed-enemy', [
                'xp'    => $this->calculateEarnedExperiencePoints($attackingClient),
                'enemy' => $this->enemy,
            ])));

            yield $this->addExperiencePoints($attackingClient);
            $attackingClient->getUser()->resetStats();

            $clients = $this->clients->filter(function (Client $client) use ($attackingClient) {
                return $client->getId() !== $attackingClient->getId();
            });

            foreach ($clients as $client) {
                yield $this->webSocket->sendToClient($client, new Render($this->template->render('/battle/player-killed-enemy-other', [
                    'xp'     => $this->calculateEarnedExperiencePoints($client),
                    'player' => $attackingClient->getUser(),
                    'enemy'  => $this->enemy,
                ])));

                yield $this->addExperiencePoints($client);
                $client->getUser()->resetStats();
            }
        });
    }

    private function addExperiencePoints(Client $client): Promise
    {
        $nextLevel = $this->ladder->getNextLevel($client->getUser()->getLevel());

        $client->getUser()->addExperiencePoints($this->calculateEarnedExperiencePoints($client));

        if ($client->getUser()->getExperiencePoints() < $nextLevel->getExperiencePoints()) {
            return new Success();
        }

        $client->getUser()->setLevel($nextLevel);

        return $this->webSocket->sendToClient($client, new Render($this->template->render('/stats/level-up')));
    }

    private function calculateEarnedExperiencePoints(Client $client): int
    {
        return (int) ($this->enemy->getLevel() + ceil($this->enemy->getLevel() / $client->getUser()->getLevel()->getNumeric()));
    }

    private function processEnemyAttack(): Promise
    {
        if (!$this->active) {
            return new Success();
        }

        $clientBeingAttacked = $this->clients->getRandom();

        if (!$clientBeingAttacked->getUser()->doesAttackHit($this->enemy)) {
            return $this->processMissedEnemyAttack($clientBeingAttacked);
        }

        return $this->processHitEnemyAttack($clientBeingAttacked);
    }

    private function processMissedEnemyAttack(Client $clientBeingAttacked): Promise
    {
        return call(function () use ($clientBeingAttacked) {
            yield $this->webSocket->sendToClient($clientBeingAttacked, new Render($this->template->render('/battle/enemy-miss-self', [
                'enemy' => $this->enemy,
            ])));

            yield $this->webSocket->sendToClients(new Render($this->template->render('/battle/enemy-miss-other', [
                'player' => $clientBeingAttacked->getUser(),
                'enemy'  => $this->enemy,
            ])), $this->clients->filter(function (Client $client) use ($clientBeingAttacked) {
                return $client->getId() !== $clientBeingAttacked->getId();
            }));
        });
    }

    private function processHitEnemyAttack(Client $clientBeingAttacked): Promise
    {
        return call(function () use ($clientBeingAttacked) {
            $damage = $clientBeingAttacked->getUser()->registerAttack($this->enemy);

            yield $this->webSocket->sendToClient($clientBeingAttacked, new Render($this->template->render('/battle/enemy-hit-self', [
                'enemy'  => $this->enemy,
                'damage' => $damage,
            ])));

            yield $this->processHitEnemyAttackForOtherClients($clientBeingAttacked, $damage);

            if ($clientBeingAttacked->getUser()->getHitPoints() <= 0) {
                $this->clients->remove($clientBeingAttacked->getId());

                if (!count($this->clients)) {
                    $this->active = false;
                }

                yield $this->processEnemyKilledPlayer($clientBeingAttacked);
            }
        });
    }

    private function processHitEnemyAttackForOtherClients(Client $clientBeingAttacked, int $damage): Promise
    {
        return $this->webSocket->sendToClients(new Render($this->template->render('/battle/enemy-hit-other', [
            'player' => $clientBeingAttacked->getUser(),
            'enemy'  => $this->enemy,
            'damage' => $damage,
        ])), $this->clients->filter(function (Client $client) use ($clientBeingAttacked) {
            return $client->getId() !== $clientBeingAttacked->getId();
        }));
    }

    private function processEnemyKilledPlayer(Client $clientBeingAttacked): Promise
    {
        return call(function () use ($clientBeingAttacked) {
            yield $this->webSocket->sendToClient($clientBeingAttacked, new Render($this->template->render('/battle/enemy-killed-player', [
                'enemy'  => $this->enemy,
            ])));

            yield $this->webSocket->sendToClients(new Render($this->template->render('/battle/enemy-killed-player-other', [
                'player' => $clientBeingAttacked->getUser(),
                'enemy'  => $this->enemy,
            ])), $this->clients->filter(function (Client $client) use ($clientBeingAttacked) {
                return $client->getId() !== $clientBeingAttacked->getId();
            }));

            $clientBeingAttacked->getUser()->resetStats();

            yield $this->mapHandler->spawnClient($clientBeingAttacked);

            if (count($this->clients)) {
                return;
            }

            yield $this->mapHandler->removeAttack($this->position);
        });
    }
}
