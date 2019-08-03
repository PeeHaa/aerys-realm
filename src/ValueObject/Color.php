<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\ValueObject;

class Color
{
    /** @var int */
    private $red;

    /** @var int */
    private $green;

    /** @var int */
    private $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        $this->red   = $red;
        $this->green = $green;
        $this->blue  = $blue;
    }

    public static function fromIndex(int $index): self
    {
        return new self(($index >> 16) & 0xFF, ($index >> 8) & 0xFF, $index & 0xFF);
    }

    public function red(): int
    {
        return $this->red;
    }

    public function green(): int
    {
        return $this->green;
    }

    public function blue(): int
    {
        return $this->blue;
    }

    public function equals(Color $color): bool
    {
        return $this->red === $color->red()
            && $this->green === $color->green()
            && $this->blue === $color->blue();
    }
}
