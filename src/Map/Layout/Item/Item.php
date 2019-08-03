<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Layout\Item;

use Amp\Promise;

abstract class Item
{
    /** @var string */
    private $name;

    /** @var string */
    private $description;

    public function __construct(string $name,string $description)
    {
        $this->name        = $name;
        $this->description = $description;
    }

    public static function fromUserRecord(array $record)
    {
        $itemName = $record['item_class_name'];

        return new $itemName();
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    abstract public function use(): Promise;
}
