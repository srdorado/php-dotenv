<?php

namespace Srdorado\Env\Processor;

abstract class AbstractProcessor implements IProcessor
{
    /**
     * The value to process
     * @var string
     */
    protected $value;

    /**
     * Construct
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
}
