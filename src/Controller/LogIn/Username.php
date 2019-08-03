<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\LogIn;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Request\Request;
use PeeHaa\AerysRealmII\Response\RenderWithPasswordAndPrefix;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;

class Username
{
    /** @var WebSocket */
    private $webSocket;

    /** @var Template */
    private $template;

    public function __construct(WebSocket $webSocket, Template $template)
    {
        $this->webSocket = $webSocket;
        $this->template  = $template;
    }

    public function process(Request $request, Client $client): Promise
    {
        return $this->webSocket->sendToClient(
            $client,
            new RenderWithPasswordAndPrefix(
                $this->template->render('/authentication/request-password'),
                sprintf('login %s ', $request->getParameterAtIndex(0))
            )
        );
    }
}
