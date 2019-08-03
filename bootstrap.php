<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII;

use Amp\Postgres\ConnectionConfig;
use Amp\Postgres\Link;
use Auryn\Injector;
use PeeHaa\AerysRealmII\Command;
use PeeHaa\AerysRealmII\Command\Handler;
use PeeHaa\AerysRealmII\Game\Engine;
use PeeHaa\AerysRealmII\Game\MapHandlerFactory;
use PeeHaa\AerysRealmII\Storage\User as UserStorage;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\User\Level\Apprentice;
use PeeHaa\AerysRealmII\User\Level\DragonSlayer;
use PeeHaa\AerysRealmII\User\Level\Explorer;
use PeeHaa\AerysRealmII\User\Level\Journeyman;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\User\Level\Newb;
use PeeHaa\AerysRealmII\User\Level\OgreHunter;
use PeeHaa\AerysRealmII\User\Level\SnakeCharmer;
use PeeHaa\AerysRealmII\User\Level\WolfRider;
use PeeHaa\AerysRealmII\User\Level\WolfTamer;
use function Amp\Postgres\pool;

require_once __DIR__ . '/vendor/autoload.php';

$configuration = require_once __DIR__ . '/config.php';

$auryn = new Injector();

$auryn->share($auryn);

$auryn->share(Link::class);
$auryn->delegate(Link::class, function () use ($configuration) {
    return pool(new ConnectionConfig(
        $configuration['database']['host'],
        ConnectionConfig::DEFAULT_PORT,
        $configuration['database']['username'],
        $configuration['database']['password'],
        $configuration['database']['name'],
    ));
});

$auryn->share(WebSocket::class);

$auryn->share(Clients::class);

$auryn->share(Template::class);
$auryn->delegate(Template::class, function() {
    $template = new Template(__DIR__ . '/templates');

    $template->registerHelper('escape', function(string $data) {
        if (stripos($data, 'javascript:') === 0) {
            $data = substr($data, 11);
        }

        return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
    });

    return $template;
});

$auryn->share(Ladder::class);

$auryn->delegate(Ladder::class, function () {
    return new Ladder(
        new Newb(),
        new Apprentice(),
        new Journeyman(),
        new Explorer(),
        new WolfTamer(),
        new WolfRider(),
        new SnakeCharmer(),
        new OgreHunter(),
        new DragonSlayer()
    );
});

$auryn->share(Handler::class);

$commandHandler = $auryn->make(Handler::class);

$commandHandler
    ->register(new Command\Help\NotAuthenticated\Overview())
    ->register(new Command\Help\NotAuthenticated\Help())
    ->register(new Command\Help\NotAuthenticated\Login())
    ->register(new Command\Help\NotAuthenticated\Register())
    ->register(new Command\Connect())
    ->register(new Command\Disconnect())
    ->register(new Command\LogIn\LogIn())
    ->register(new Command\LogIn\Username())
    ->register(new Command\LogIn\Password())
    ->register(new Command\Register\Register())
    ->register(new Command\Register\Username())
    ->register(new Command\Register\Password())
    ->register(new Command\Register\Email())
    ->register(new Command\Help\Authenticated\Overview())
    ->register(new Command\Help\Authenticated\Help())
    ->register(new Command\Help\Authenticated\Look())
    ->register(new Command\Help\Authenticated\Walk())
    ->register(new Command\Help\Authenticated\Attack())
    ->register(new Command\Help\Authenticated\Info())
    ->register(new Command\Help\Authenticated\Clear())
    ->register(new Command\Help\Authenticated\Quest())
    ->register(new Command\Help\Authenticated\Inventory())
    ->register(new Command\Help\Authenticated\Give())
    ->register(new Command\Log\Clear())
    ->register(new Command\Navigation\Look\Look())
    ->register(new Command\Navigation\Look\North())
    ->register(new Command\Navigation\Look\South())
    ->register(new Command\Navigation\Look\East())
    ->register(new Command\Navigation\Look\West())
    ->register(new Command\Navigation\Walk\North())
    ->register(new Command\Navigation\Walk\South())
    ->register(new Command\Navigation\Walk\East())
    ->register(new Command\Navigation\Walk\West())
    ->register(new Command\Battle\Attack())
    ->register(new Command\Battle\Pet())
    ->register(new Command\Quest\Quest())
    ->register(new Command\Stats\Info())
    ->register(new Command\Stats\InfoPlayer())
    ->register(new Command\Item\Inventory())
    ->register(new Command\Item\Give())
    ->register(new Command\Admin\Online())
    ->register(new Command\Admin\Restart())
;

$auryn->share(MapHandlerFactory::class);
$auryn->define(MapHandlerFactory::class, [
    ':mapsRootDirectory' => __DIR__ . '/data/maps',
]);

$auryn->share(Engine::class);
$auryn->delegate(Engine::class, function () use ($auryn) {
    $mapHandlerFactory = $auryn->make(MapHandlerFactory::class);

    $mapHandlers = [
        $mapHandlerFactory->build('starters-realm'),
    ];

    return new Engine($auryn->make(WebSocket::class), $auryn->make(UserStorage::class), ...$mapHandlers);
});
