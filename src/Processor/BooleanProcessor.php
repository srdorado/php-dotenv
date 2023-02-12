<?php

namespace Srdorado\Env\Processor;

class BooleanProcessor extends AbstractProcessor
{
    public function canBeProcessed()
    {
        $loweredValue = strtolower($this->value);

        return in_array($loweredValue, ['true', 'false'], true);
    }

    public function execute()
    {
        return strtolower($this->value) === 'true';
    }
}
