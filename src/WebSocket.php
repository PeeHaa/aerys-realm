<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII;

use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Http\Server\Websocket\Message;
use Amp\Http\Server\Websocket\Websocket as AmpWebSocket;
use Amp\Promise;
use PeeHaa\AerysRealmII\Command\Handler;
use PeeHaa\AerysRealmII\Request\Request as ClientRequest;
use PeeHaa\AerysRealmII\Response\Response as ClientResponse;

class WebSocket extends AmpWebSocket
{
    /** @var Clients */
    private $clients;

    /** @var Handler */
    private $commandHandler;

    public function __construct(Clients $clients, Handler $commandHandler)
    {
        $this->clients        = $clients;
        $this->commandHandler = $commandHandler;

        parent::__construct();
    }

    public function onHandshake(Request $request, Response $response): Response
    {
        return $response;
    }

    public function onOpen(int $clientId, Request $request)
    {
        $this->clients->add(new Client($clientId));
    }

    public function onData(int $clientId, Message $message): \Generator
    {
        $this->commandHandler->handle(new ClientRequest(yield $message->read()), $this->clients->getById($clientId));
    }

    public function onClose(int $clientId, int $code, string $reason)
    {
        $this->commandHandler->handle(new ClientRequest('disconnect'), $this->clients->getById($clientId));

        $this->clients->remove($clientId);
    }

    public function sendToClient(Client $client, ClientResponse $response): Promise
    {
        return $this->send((string) $response, $client->getId());
    }

    public function sendToClients(ClientResponse $response, Clients $clients): Promise
    {
        return $this->multicast((string) $response, $clients->getIds());
    }
}
