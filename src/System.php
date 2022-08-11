<?php

namespace PhpGum;

/** @internal */
class System
{
    public static function exec(string $command, &$output = null, &$resultCode = null): string|false
    {
        return exec($command, $output, $resultCode);
    }
}
