<?php

namespace Srdorado\Env\Processor;

class NullProcessor extends AbstractProcessor
{
    public function canBeProcessed()
    {
        return in_array($this->value, ['null', 'NULL'], true);
    }

    public function execute()
    {
        return null;
    }
}
