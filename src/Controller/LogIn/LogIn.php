<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\LogIn;

use Amp\Promise;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Response\RenderWithPrefix;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;

class LogIn
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

    public function process(Client $client): Promise
    {
        return $this->webSocket->sendToClient(
            $client,
            new RenderWithPrefix($this->template->render('/authentication/request-username'), 'login ')
        );
    }
}
