<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Data\Maps;

use PeeHaa\AerysRealmII\Map\Layout\Enemy\AttackDummy;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\Ogre;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\SmallCat;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\VenomousSnake;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\ViciousDog;
use PeeHaa\AerysRealmII\Map\Layout\Enemy\WarHorse;
use PeeHaa\AerysRealmII\Map\Layout\Npc\AnimalTamer;
use PeeHaa\AerysRealmII\Map\Layout\Npc\GateKeeper;
use PeeHaa\AerysRealmII\Map\Layout\Npc\Introdor;
use PeeHaa\AerysRealmII\Map\Layout\Npc\LittleKid;
use PeeHaa\AerysRealmII\Map\Layout\Npc\OldMan;
use PeeHaa\AerysRealmII\Map\Layout\Npc\SirTutorius;
use PeeHaa\AerysRealmII\Map\Layout\Npc\Sorcerer;
use PeeHaa\AerysRealmII\Map\Layout\Npc\SorcerersSon;
use PeeHaa\AerysRealmII\Map\Layout\Tile\Bushes;
use PeeHaa\AerysRealmII\Map\Layout\Tile\House;
use PeeHaa\AerysRealmII\Map\Layout\Tile\Hut;
use PeeHaa\AerysRealmII\Map\Layout\Tile\MagicTower;
use PeeHaa\AerysRealmII\Map\Layout\Tile\Path;
use PeeHaa\AerysRealmII\Map\Layout\Tile\ProvingGrounds;
use PeeHaa\AerysRealmII\Map\Layout\Tile\Shop;
use PeeHaa\AerysRealmII\Map\Layout\Tile\TinyHouse;
use PeeHaa\AerysRealmII\Map\Layout\Tile\Water;
use PeeHaa\AerysRealmII\Map\Specifications\Enemies;
use PeeHaa\AerysRealmII\Map\Specifications\Enemy;
use PeeHaa\AerysRealmII\Map\Specifications\Npc;
use PeeHaa\AerysRealmII\Map\Specifications\Npcs;
use PeeHaa\AerysRealmII\Map\Specifications\Specifications;
use PeeHaa\AerysRealmII\Map\Specifications\Tile;
use PeeHaa\AerysRealmII\Map\Specifications\Tiles;
use PeeHaa\AerysRealmII\ValueObject\Color;

$tiles = [
    new Tile(new Color(34, 177, 76), Bushes::class),
    new Tile(new Color(0, 0, 0), Path::class),
    new Tile(new Color(200, 191, 231), ProvingGrounds::class),
    new Tile(new Color(63, 72, 204), Water::class),
    new Tile(new Color(112, 146, 190), Shop::class),
    new Tile(new Color(153, 217, 234), House::class),
    new Tile(new Color(181, 230, 29), TinyHouse::class),
    new Tile(new Color(239, 228, 176), MagicTower::class),
    new Tile(new Color(255, 201, 14), Bushes::class), // old casino, now obsolete
    new Tile(new Color(255, 174, 201), Hut::class),
];

$enemies = [
    new Enemy(1, new Color(200, 191, 231), AttackDummy::class, 3, 3),
    new Enemy(2, new Color(112, 146, 190), SmallCat::class, 4, 6),
    new Enemy(3, new Color(112, 146, 190), ViciousDog::class, 2, 4),
    new Enemy(4, new Color(153, 217, 234), SmallCat::class, 0, 1),
    new Enemy(5, new Color(153, 217, 234), ViciousDog::class, 2, 3),
    new Enemy(6, new Color(153, 217, 234), VenomousSnake::class, 2, 4),
    new Enemy(7, new Color(153, 217, 234), WarHorse::class, 2, 3),
    new Enemy(8, new Color(181, 230, 29), VenomousSnake::class, 1, 3),
    new Enemy(9, new Color(181, 230, 29), WarHorse::class, 3, 4),
    new Enemy(10, new Color(181, 230, 29), Ogre::class, 2, 4),
];

$npcs = [
    new Npc(new Color(200, 191, 231), SirTutorius::class),
    new Npc(new Color(112, 146, 190), GateKeeper::class),
    new Npc(new Color(181, 230, 29), Introdor::class),
    new Npc(new Color(163, 73, 164), LittleKid::class),
    new Npc(new Color(163, 40, 40), OldMan::class),
    new Npc(new Color(239, 228, 176), SorcerersSon::class),
    new Npc(new Color(255, 201, 14), Sorcerer::class),
    new Npc(new Color(237, 28, 36), AnimalTamer::class),
];

return new Specifications('starters-realm', 'Starter\'s realm', new Tiles(...$tiles), new Enemies(...$enemies), new Npcs(...$npcs));
