<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Controller\Admin;

use function Amp\call;
use Amp\Loop;
use Amp\Promise;
use Amp\Success;
use PeeHaa\AerysRealmII\Client;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Request\Request;
use PeeHaa\AerysRealmII\Response\Render;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\WebSocket;

class Restart
{
    /** @var WebSocket */
    private $webSocket;

    /** @var Template */
    private $template;

    /** @var Engine */
    private $engine;

    private $minutesWatcher;

    private $minutesCounter = 1;

    private $secondsWatcher;

    private $secondsCounter = 0;

    public function __construct(WebSocket $webSocket, Template $template, Engine $engine)
    {
        $this->webSocket = $webSocket;
        $this->template  = $template;
        $this->engine    = $engine;
    }

    public function process(Client $client, Request $request): Promise
    {
        return $this->countDownMinutes();
    }

    private function countDownMinutes(): Promise
    {
        return call(function () {
            yield $this->webSocket->sendToClients(new Render($this->template->render('/admin/restart', [
                'seconds' => 5 * 60,
            ])), $this->engine->getClients());

            $this->minutesWatcher = Loop::repeat(60000, function () {
                yield $this->webSocket->sendToClients(new Render($this->template->render('/admin/restart', [
                    'seconds' => (5 * 60) - ($this->minutesCounter * 60),
                ])), $this->engine->getClients());

                $this->minutesCounter++;

                if ($this->minutesCounter === 4) {
                    $this->countDownSeconds();

                    Loop::cancel($this->minutesWatcher);

                    return;
                }
            });
        });
    }

    private function countDownSeconds(): void
    {
        Loop::delay(30000, function () {
            yield $this->webSocket->sendToClients(new Render($this->template->render('/admin/restart', [
                'seconds' => 30,
            ])), $this->engine->getClients());
        });

        Loop::delay(50000, function () {
            $this->secondsCounter = 10;

            $this->secondsWatcher = Loop::repeat(1000, function () {
                if ($this->secondsCounter === 0) {
                    Loop::cancel($this->secondsWatcher);

                    $this->restart();

                    return;
                }

                yield $this->webSocket->sendToClients(new Render($this->template->render('/admin/restart', [
                    'seconds' => $this->secondsCounter,
                ])), $this->engine->getClients());

                $this->secondsCounter--;
            });
        });
    }

    private function restart(): void
    {
        Loop::delay(1000, function () {
            yield $this->webSocket->sendToClients(new Render($this->template->render('/admin/restarting')), $this->engine->getClients());

            exit;
        });
    }
}
