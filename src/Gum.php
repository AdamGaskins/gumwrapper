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

        $command = ['choose'];

        if ($limit !== null) {
            $command[] = $limit < 1 ? '--no-limit' : ('--limit ' . intval($limit));
        }

        if ($height !== null) {
            $command[] = '--height ' . intval($height);
        }

        $command[] = implode(' ', $options);

        return self::call(implode(' ', $command));
    }

    /**
     * @param  string|null  $prompt
     * @param  string|null  $affirmativeText
     * @param  string|null  $negativeText
     * @param  bool|null  $default
     * @return bool
     */
    public static function confirm($prompt = null, $affirmativeText = null, $negativeText = null, $default = null)
    {
        $command = ['confirm'];

        if ($prompt !== null) {
            $command[] = escapeshellarg($prompt);
        }

        if ($affirmativeText !== null) {
            $command[] = '--affirmative ' . escapeshellarg($affirmativeText);
        }

        if ($negativeText !== null) {
            $command[] = '--negative ' . escapeshellarg($negativeText);
        }

        if ($default !== null) {
            $command[] = '--default='.(!!$default ? '1' : '0');
        }

        self::call(implode(' ', $command), $output, $resultCode);

        return $resultCode === 0;
    }

    /**
     * @param  string  $arguments
     * @return string|false
     */
    protected static function call($arguments = '', &$output = null, &$resultCode = null): string|false
    {
        return System::exec('gum '.$arguments, $output, $resultCode);
    }
}
