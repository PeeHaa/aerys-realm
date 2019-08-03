<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Game;

use Auryn\Injector;
use PeeHaa\AerysRealmII\Map\Reader\Parser;
use PeeHaa\AerysRealmII\Template\Template;
use PeeHaa\AerysRealmII\User\Level\Ladder;
use PeeHaa\AerysRealmII\WebSocket;

class MapHandlerFactory
{
    /** @var string */
    private $mapsRootDirectory;

    /** @var Parser */
    private $parser;

    /** @var Injector */
    private $auryn;

    public function __construct(string $mapsRootDirectory, Parser $parser, Injector $auryn)
    {
        $this->mapsRootDirectory = $mapsRootDirectory;
        $this->parser            = $parser;
        $this->auryn             = $auryn;
    }

    public function build(string $mapId): MapHandler
    {
        $tileHandlers = [];

        $map = $this->parser->parse(
            sprintf('%s/%s.png', $this->mapsRootDirectory, $mapId),
            require sprintf('%s/%s.php', $this->mapsRootDirectory, $mapId)
        );

        foreach ($map->getTiles() as $tile) {
            $tileHandlers[] = $this->auryn->make(TileHandler::class, [
                ':tile' => $tile,
            ]);
        }

        return new MapHandler(
            $this->auryn->make(WebSocket::class),
            $this->auryn->make(Template::class),
            $map,
            $this->auryn->make(Ladder::class),
            ...$tileHandlers
        );
    }
}
