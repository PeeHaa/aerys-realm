<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Response;

class RenderWithPasswordAndPrefix extends RenderResponse
{
    public function __construct(string $html, string $prefix)
    {
        parent::__construct($html, new InputType(InputType::PASSWORD), $prefix);
    }
}
