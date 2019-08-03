<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Item;

use Amp\Promise;
use Amp\Success;

class MagicWand extends Item
{
    public function __construct()
    {
        parent::__construct('The Sorcerer\'s Magic Wand', 'A glowing magic wand which belongs to the sorcerer');
    }

    public function use(): Promise
    {
        return new Success();
    }
}
