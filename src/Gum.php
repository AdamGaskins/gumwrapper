<?php

namespace PhpGum;

class Gum
{
    /**
     * @param  array<string>  $options
     * @param  int|null  $limit
     * @param  int|null  $height
     * @return string|false
     */
    public static function choose($options, $limit = null, $height = null)
    {
        $options = array_map(function($arg) { return escapeshellarg($arg); }, $options);

        $arguments = [];

        if ($limit !== null) {
            $arguments[] = $limit < 1 ? '--no-limit' : ('--limit ' . intval($limit));
        }

        if ($height !== null) {
            $arguments[] = '--height ' . intval($height);
        }

        $arguments[] = implode(' ', $options);

        return self::call('choose ' . implode(' ', $arguments));
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
