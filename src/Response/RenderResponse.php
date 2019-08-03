<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Response;

abstract class RenderResponse implements Response
{
    /** @var string */
    private $html;

    /** @var string */
    private $inputType;

    /** @var string */
    private $prefix;

    public function __construct(string $html, InputType $inputType, string $prefix = '')
    {
        $this->html      = $html;
        $this->inputType = $inputType;
        $this->prefix    = $prefix;
    }

    public function __toString(): string
    {
        return json_encode([
            'type'      => 'render',
            'html'      => $this->html,
            'inputType' => $this->inputType->getValue(),
            'prefix'    => $this->prefix,
        ]);
    }
}
