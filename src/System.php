<?php

namespace GumWrapper;

/**
 * @internal
 * A wrapper around standard PHP methods. Only purpose is to be mocked in tests.
 */
class System
{
    public function exec(string $command, &$output = null, &$resultCode = null)
    {
        return exec($command, $output, $resultCode);
    }

    public function proc_open($command, array $descriptor_spec, array &$pipes, string $cwd = null, array $env_vars = null, array $options = null)
    {
        return proc_open($command, $descriptor_spec, $pipes, $cwd, $env_vars, $options);
    }

    public function proc_terminate($process, int $signal = 15)
    {
        return proc_terminate($process, $signal);
    }
}
