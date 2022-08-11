<?php

namespace PhpGum;

class Gum
{
    /**
     * @param  array<string>  $options
     * @return string|false
     */
    public static function choose($options)
    {
        $options = array_map(function($arg) { return escapeshellarg($arg); }, $options);
        return self::call('choose '.implode(' ', $options));
    }

    /**
     * @param  string  $arguments
     * @return string|false
     */
    protected static function call($arguments = ''): string|false
    {
        return System::exec('gum '.$arguments);
    }
}
