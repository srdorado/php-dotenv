<?php

namespace Srdorado\Env\Processor;

interface IProcessor
{
    /**
     * Construct
     *
     * @param $value
     */
    public function __construct($value);

    /**
     * @return mixed
     */
    public function canBeProcessed();

    /**
     * @return mixed
     */
    public function execute();
}
