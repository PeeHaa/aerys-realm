<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Command;

use Amp\Promise;
use Auryn\Injector;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Clients;
use PeeHaa\AerysRealmII\Controller\UnknownCommand;
use PeeHaa\AerysRealmII\Request\Request;

class Handler
{
    /** @var Injector */
    private $auryn;

    /** @var Clients */
    private $clients;

    /** @var Command[] */
    private $commands = [];

    public function __construct(Injector $auryn, Clients $clients)
    {
        $this->auryn   = $auryn;
        $this->clients = $clients;
    }

    public function register(Command $command): self
    {
        $this->commands[] = $command;

        return $this;
    }

    public function handle(Request $request, Client $client): Promise
    {
        foreach ($this->commands as $command) {
            if (!$command->accessLevelMatches($client->getAccessLevel()) || !$command::matches($request)) {
                continue;
            }

            return $this->auryn->execute($command->getController(), [
                ':client'  => $client,
                ':request' => $request,
            ]);
        }

        return $this->auryn->execute([UnknownCommand::class, 'process'], [
            ':client' => $client,
        ]);
    }
}
