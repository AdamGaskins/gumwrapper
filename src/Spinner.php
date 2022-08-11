<?php

namespace PhpGum;

/** @internal */
class Spinner
{
    protected $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function stop()
    {
        if (! $this->resource) {
            throw new \Exception('Spinner is not running.');
        }

        System::proc_terminate($this->resource);
        $this->resource = null;
    }
}
