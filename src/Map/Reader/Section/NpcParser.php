<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Map\Reader\Section;

use PeeHaa\AerysRealmII\Map\Layout\Npcs;
use PeeHaa\AerysRealmII\Map\Reader\MapImage;
use PeeHaa\AerysRealmII\Map\Specifications\Npcs as NpcsSpecification;
use PeeHaa\AerysRealmII\Template\Template;

class NpcParser
{
    /** @var Template */
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function parse(MapImage $mapImage, NpcsSpecification $specification): Npcs
    {
        $npcs = [];

        foreach ($mapImage->getNpcsIterator() as $mapImagePixel) {
            if (!$specification->colorHasDefinedNpc($mapImagePixel->color())) {
                continue;
            }

            $npcClass = $specification->getNpcByColor($mapImagePixel->color())->getClassName();

            $npcs[] = new $npcClass($this->template, $mapImagePixel->position());
        }

        return new Npcs(...$npcs);
    }
}
