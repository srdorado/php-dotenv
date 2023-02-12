<?php

namespace Srdorado\Env\Processor;

class NumberProcessor extends AbstractProcessor
{
    public function canBeProcessed()
    {
        return is_numeric($this->value);
    }

    public function execute()
    {
        $int = filter_var($this->value, FILTER_VALIDATE_INT);

        if ($int !== false) {
            return $int;
        }

        return (float) $this->value;
    }
}
