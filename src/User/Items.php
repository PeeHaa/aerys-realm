<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\User;

use PeeHaa\AerysRealmII\Map\Layout\Item\Item;

class Items implements \Iterator, \Countable
{
    private $items = [];

    public function __construct(Item ...$items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public static function fromUserRecordSet(array $recordSet): self
    {
        $items = new self();

        foreach ($recordSet as $record) {
            if ($record['item_class_name'] === null) {
                continue;
            }

            if ($items->getItem($record['item_class_name'])) {
                continue;
            }

            $items->add(Item::fromUserRecord($record));
        }

        return $items;
    }

    public function add(Item $item): void
    {
        $this->items[get_class($item)] = $item;
    }

    public function remove(string $className): void
    {
        unset($this->items[$className]);
    }

    public function getItem(string $itemName): ?Item
    {
        if (!isset($this->items[$itemName])) {
            return null;
        }

        return $this->items[$itemName];
    }

    public function current(): Item
    {
        return current($this->items);
    }

    public function next()
    {
        next($this->items);
    }

    public function key(): ?string
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        return $this->key() !== null;
    }

    public function rewind()
    {
        reset($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
