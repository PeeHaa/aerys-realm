<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Template;

class HelperNotDefined extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('The template function `%s` is not defined.', $name));
    }
}
