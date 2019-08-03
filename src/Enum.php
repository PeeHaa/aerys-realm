<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII;

abstract class Enum
{
    private $value;

    final public function __construct($value)
    {
        $reflection = new \ReflectionClass(\get_called_class());

        if (!in_array($value, $reflection->getConstants())) {
            throw new \UnexpectedValueException("Value '$value' is not part of the enum " . \get_called_class());
        }

        $this->value = $value;
    }

    final public function getValue()
    {
        return $this->value;
    }

    final public function equals(self $value): bool
    {
        return $this->getValue() === $value->getValue();
    }
}
