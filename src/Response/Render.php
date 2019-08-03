<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Response;

class Render extends RenderResponse
{
    public function __construct(string $html)
    {
        parent::__construct($html, new InputType(InputType::TEXT));
    }
}
