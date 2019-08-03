<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Register;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Request\Request;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Response\RenderWithPasswordAndPrefix;
use PeeHaa\AerysRealmII\Response\RenderWithPrefix;
use PeeHaa\AerysRealmII\Storage\User as UserStorage;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;
use function Amp\call;

class Username
{
    /** @var WebSocket */
    private $webSocket;

    /** @var Template */
    private $template;

    /** @var UserStorage */
    private $userStorage;

    public function __construct(WebSocket $webSocket, Template $template, UserStorage $userStorage)
    {
        $this->webSocket   = $webSocket;
        $this->template    = $template;
        $this->userStorage = $userStorage;
    }

    public function process(Request $request, Client $client): Promise
    {
        return call(function() use ($request, $client) {
            $user = yield $this->userStorage->getByUsername($request->getParameterAtIndex(0));

            if ($user) {
                return $this->processInvalidUsername($client);
            }

            return $this->webSocket->sendToClient(
                $client,
                new RenderWithPasswordAndPrefix(
                    $this->template->render('/registration/request-password'),
                    sprintf('register %s ', $request->getParameterAtIndex(0))
                )
            );
        });
    }

    private function processInvalidUsername(Client $client): Promise
    {
        return call(function () use ($client) {
            yield $this->webSocket->sendToClient(
                $client,
                new Render($this->template->render('/registration/username-exists')
            ));

            yield $this->webSocket->sendToClient(
                $client,
                new RenderWithPrefix($this->template->render('/registration/request-username'), 'register ')
            );
        });
    }
}
