<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Template;

class VariableNotDefined extends \Exception
{
    public function __construct(string $key)
    {
        parent::__construct(sprintf('The template variable `%s` is not defined.', $key));
    }
}
