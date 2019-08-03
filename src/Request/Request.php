<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Request;

class Request
{
    /** @var string */
    private $command;

    /** @var string[] */
    private $parameters = [];

    public function __construct(string $message)
    {
        $messageParts = explode(' ', $message);

        $this->command    = array_shift($messageParts);
        $this->parameters = $messageParts;
    }

    public function isCommand(string $command): bool
    {
        return $this->command === $command;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function hasParameters(): bool
    {
        return (bool) count($this->parameters);
    }

    public function hasNumberOfParameters(int $numberOfParameters): bool
    {
        return count($this->parameters) === $numberOfParameters;
    }

    public function hasParameterAtIndex(int $index): bool
    {
        return array_key_exists($index, $this->parameters);
    }

    public function getParameterAtIndex(int $index): ?string
    {
        if (!$this->hasParameterAtIndex($index)) {
            return null;
        }

        return $this->parameters[$index];
    }
}
