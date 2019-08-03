<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Response;

class CommandResponse implements Response
{
    /** @var string */
    private $command;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function __toString(): string
    {
        return json_encode([
            'type'    => 'command',
            'command' => $this->command,
        ]);
    }
}
