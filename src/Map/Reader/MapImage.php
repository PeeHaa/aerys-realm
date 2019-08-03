<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Reader;

use PeeHaa\AerysRealmII\ValueObject\Color;
use PeeHaa\AerysRealmII\ValueObject\Dimensions;
use PeeHaa\AerysRealmII\ValueObject\MapImagePixel;
use PeeHaa\AerysRealmII\ValueObject\Position;

class MapImage
{
    /** @var resource */
    private $image;

    /** @var Dimensions */
    private $dimensions;

    public function __construct(string $filename)
    {
        $this->image      = imagecreatefrompng($filename);
        $this->dimensions = $this->buildDimensions($filename);
    }

    private function buildDimensions(string $filename): Dimensions
    {
        $height = getimagesize($filename)[1];

        for ($x = 0; $x < getimagesize($filename)[0]; $x++) {
            if (imagecolorat($this->image, $x, 0) !== 16777215) {
                continue;
            }

            return new Dimensions($x, $height);
        }

        throw new \Exception('Invalid map file.');
    }

    /**
     * @return \Generator|MapImagePixel[]
     */
    public function getTilesIterator(): \Generator
    {
        for ($y = 0; $y < $this->dimensions->getHeight(); $y++) {
            for ($x = 0; $x < $this->dimensions->getWidth(); $x++) {
                yield new MapImagePixel(new Position($x, $y), Color::fromIndex(imagecolorat($this->image, $x, $y)));
            }
        }
    }

    /**
     * @return \Generator|MapImagePixel[]
     */
    public function getSpawnsIterators(): \Generator
    {
        for ($y = 0; $y < $this->dimensions->getHeight(); $y++) {
            for ($x = 0; $x < $this->dimensions->getWidth(); $x++) {
                yield new MapImagePixel(
                    new Position($x, $y),
                    Color::fromIndex(imagecolorat($this->image, $x + 1 + $this->dimensions->getWidth(), $y))
                );
            }
        }
    }

    /**
     * @return \Generator|MapImagePixel[]
     */
    public function getEnemiesIterator(): \Generator
    {
        for ($y = 0; $y < $this->dimensions->getHeight(); $y++) {
            for ($x = 0; $x < $this->dimensions->getWidth(); $x++) {
                yield new MapImagePixel(
                    new Position($x, $y),
                    Color::fromIndex(imagecolorat($this->image, $x + 2 + ($this->dimensions->getWidth() * 2), $y))
                );
            }
        }
    }

    /**
     * @return \Generator|MapImagePixel[]
     */
    public function getNpcsIterator(): \Generator
    {
        for ($y = 0; $y < $this->dimensions->getHeight(); $y++) {
            for ($x = 0; $x < $this->dimensions->getWidth(); $x++) {
                yield new MapImagePixel(
                    new Position($x, $y),
                    Color::fromIndex(imagecolorat($this->image, $x + 3 + ($this->dimensions->getWidth() * 3), $y))
                );
            }
        }
    }
}
