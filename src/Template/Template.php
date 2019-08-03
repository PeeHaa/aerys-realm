<?php declare(strict_types=1);

namespace PeeHaa\AerysRealmII\Template;

use Amp\Promise;
use function Amp\call;
use function Amp\ParallelFunctions\parallel;

class Template
{
    /** @var string */
    private $basePath;

    /** @var mixed[] */
    private $_variables = [];

    /** @var \Closure[] */
    private $_helpers = [];

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public function registerHelper(string $name, callable $callable): void
    {
        $this->_helpers[$name] = $callable;
    }

    /**
     * @todo: make async
     */
    public function render(string $filename, array $variables = []): string
    {
        // we store the current state of the template variables
        // so that we have isolated cases on multiple calls to render()
        $backupVariables = $this->_variables;

        if ($variables) {
            $this->_variables = $variables;
        }

        try {
            ob_start();
            /** @noinspection PhpIncludeInspection */
            require $this->basePath . $filename . '.php';
        } finally {
            $output = ob_get_clean();
        }

        $this->_variables = $backupVariables;

        return trim($output);
    }

    /**
     * @return mixed
     * @throws VariableNotDefined
     */
    public function __get(string $key)
    {
        if (!array_key_exists($key, $this->_variables)) {
            throw new VariableNotDefined($key);
        }

        return $this->_variables[$key];
    }

    public function __isset(string $key): bool
    {
        return isset($this->_variables[$key]);
    }

    /**
     * @param mixed[] $arguments
     * @throws HelperNotDefined
     */
    public function __call(string $name, array $arguments = []): string
    {
        if (!array_key_exists($name, $this->_helpers)) {
            throw new HelperNotDefined($name);
        }

        return $this->_helpers[$name](...$arguments);
    }
}
