<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII;

use Amp\Http\Server\Router;
use Amp\Http\Server\Server as HttpServer;
use Amp\Http\Server\StaticContent\DocumentRoot;
use Amp\Log\ConsoleFormatter;
use Amp\Log\StreamHandler;
use Amp\Loop;
use Auryn\Injector;
use Monolog\Logger;
use PeeHaa\AerysRealmII\Game\Engine;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use function Amp\ByteStream\getStdout;
use function Amp\Socket\listen;

class Server
{
    private const DEFAULT_PORT = 1337;

    /** @var Injector */
    private $auryn;

    /** @var string[] */
    private $arguments;

    /** @var string|null */
    private $tickWatcher;

    public function __construct(Injector $auryn, array $arguments)
    {
        $this->auryn     = $auryn;
        $this->arguments = $arguments;

        array_shift($this->arguments);
    }

    public function start(Engine $engine): void
    {
        if ($this->needsHelpText()) {
            echo $this->renderHelpText();

            return;
        }

        Loop::run(function () use ($engine) {
            $router = new Router();
            $router->addRoute('GET', '/ws', $this->auryn->make(WebSocket::class));
            $router->setFallback(new DocumentRoot(__DIR__ . '/../public'));

            $sockets = [
                listen('0.0.0.0:' . $this->getWebInterfacePort()),
                listen('[::]:' . $this->getWebInterfacePort()),
            ];

            $server = new HttpServer($sockets, $router, $this->getLogger());

            yield $server->start();

            $this->tickWatcher = Loop::repeat(1000, function () use ($engine) {
                yield $engine->tick();
            });

            Loop::repeat(10000, function () use ($engine) {
                yield $engine->persist();
            });
        });
    }

    private function needsHelpText(): bool
    {
        if (in_array('--help', $this->arguments, true)) {
            return true;
        }

        if (in_array('-h', $this->arguments, true)) {
            return true;
        }

        return false;
    }

    private function getLogger(): LoggerInterface
    {
        if (!in_array('--debug', $this->arguments, true)) {
            return new NullLogger();
        }

        $logHandler = new StreamHandler(getStdout());
        $logHandler->setFormatter(new ConsoleFormatter());

        $logger = new Logger('server');
        $logger->pushHandler($logHandler);

        return $logger;
    }

    private function getWebInterfacePort(): int
    {
        foreach ($this->arguments as $argument) {
            if (strpos($argument, '--port=') === false) {
                continue;
            }

            return (int) substr($argument, 7);
        }

        return self::DEFAULT_PORT;
    }

    private function renderHelpText(): string
    {
        return <<<'EOD'
server --output --port=80

Usage:
  --debug       Outputs information to stdout
  --port=PORT   Specifies the PORT under which the web interface is available
EOD;
    }
}
