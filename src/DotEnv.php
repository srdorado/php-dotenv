<?php

namespace Srdorado\Env;

use Srdorado\Env\Processor\AbstractProcessor;
use InvalidArgumentException;
use RuntimeException;

class DotEnv
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected $path;

    /**
     * Configure the options on which the parsed will act
     *
     * @var string[]
     */
    protected $processors = [];

    public function __construct($path, $processors = null)
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException(sprintf('%s does not exist', $path));
        }

        $this->path = $path;

        $this->setProcessors($processors);
    }

    private function setProcessors($processors = null)
    {
        /**
         * Fill with default processors
         */
        if ($processors === null) {
            $this->processors = [
                '\Srdorado\Env\Processor\NullProcessor',
                '\Srdorado\Env\Processor\BooleanProcessor',
                '\Srdorado\Env\Processor\NumberProcessor',
                '\Srdorado\Env\Processor\QuotedProcessor'
            ];

            return $this;
        }

        foreach ($processors as $processor) {
            if (is_subclass_of($processor, '\Srdorado\Env\Processor\AbstractProcessor')) {
                $this->processors[] = $processor;
            }
        }

        return $this;
    }

    /**
     * Processes the $path of the instances and parses the values into $_SERVER and $_ENV,
     * also returns all the data that has been read.
     * Skips empty and commented lines.
     */
    public function load()
    {
        if (!is_readable($this->path)) {
            throw new RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = $this->processValue($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    /**
     * Process the value with the configured processors
     *
     * @param string $value The value to process
     * @return mixed
     */
    private function processValue($value)
    {
        /**
         * First trim spaces and quotes if configured
         */
        $trimmedValue = trim($value);

        foreach ($this->processors as $processor) {
            /** @var AbstractProcessor $processorInstance */
            $processorInstance = new $processor($trimmedValue);

            if ($processorInstance->canBeProcessed()) {
                return $processorInstance->execute();
            }
        }

        /**
         * Does not match any processor options, return as is
         */
        return $trimmedValue;
    }
}
