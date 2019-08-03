<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\LogIn;

use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Clients;
use PeeHaa\AerysRealmII\Controller\Navigation\Look\Look;
use PeeHaa\AerysRealmII\User\User;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Request\Request;
use PeeHaa\AerysRealmII\Response\CommandResponse;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Response\RenderWithPrefix;
use PeeHaa\AerysRealmII\Storage\User as UserStorage;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;
use function Amp\ParallelFunctions\parallel;

class Password
{
    /** @var WebSocket */
    private $webSocket;

    /** @var Template */
    private $template;

    /** @var UserStorage */
    private $userStorage;

    /** @var Clients */
    private $clients;

    /** @var Engine */
    private $engine;

    public function __construct(
        WebSocket $webSocket,
        Template $template,
        UserStorage $userStorage,
        Clients $clients,
        Engine $engine
    ) {
        $this->webSocket   = $webSocket;
        $this->template    = $template;
        $this->userStorage = $userStorage;
        $this->clients     = $clients;
        $this->engine      = $engine;
    }

    public function process(Request $request, Client $client): Promise
    {
        return call(function() use ($request, $client) {
            /** @var User $user */
            $user = yield $this->userStorage->getByUsername($request->getParameterAtIndex(0));

            if (!$user) {
                return $this->processInvalidLogin($client);
            }

            $validPassword = yield parallel(function () use ($user, $request) {
                return password_verify($request->getParameterAtIndex(1), $user->getPasswordHash());
            })();

            if (!$validPassword) {
                return $this->processInvalidLogin($client);
            }

            $this->clients->logIn($client, $user);

            yield $this->engine->placeClientOnMap($client);

            yield $this->webSocket->sendToClient($client, new CommandResponse('clear'));

            yield $this->webSocket->sendToClient($client,
                new Render($this->template->render('/authentication/success', [
                    'user' => $user,
                ]))
            );

            yield (new Look($this->webSocket, $this->template, $this->engine))->process($client);

            if (null === $npc = $this->engine->getNpcOnMapPosition($client->getUser()->getMapPosition())) {
                return new Success();
            }

            if ($npc->getOnEntranceMessage($client)) {
                yield $this->webSocket->sendToClient($client, new Render($npc->getOnEntranceMessage($client)));
            }
        });
    }

    private function processInvalidLogin(Client $client): Promise
    {
        return call(function () use ($client) {
            yield $this->webSocket->sendToClient(
                $client,
                new Render($this->template->render('/authentication/failure'))
            );

            yield $this->webSocket->sendToClient(
                $client,
                new RenderWithPrefix($this->template->render('/authentication/request-username'), 'login ')
            );
        });
    }
}
