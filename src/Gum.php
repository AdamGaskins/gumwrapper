<?php

namespace PhpGum;

use Exception;

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

        $command = [self::executable(), 'choose'];

        if ($limit !== null) {
            $command[] = $limit < 1 ? '--no-limit' : ('--limit ' . intval($limit));
        }

        if ($height !== null) {
            $command[] = '--height ' . intval($height);
        }

        $command[] = implode(' ', $options);

        return System::exec(implode(' ', $command));
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
        $command = [self::executable(), 'confirm'];

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

        $output = [];
        $resultCode = null;
        System::exec(implode(' ', $command), $output, $resultCode);

        return $resultCode === 0;
    }

    public static function spin(string $title = null, string $spinner = null)
    {
        $command = [self::executable(), 'spin'];

        if ($title !== null) {
            $command[] = '--title=' . escapeshellarg($title);
        }

        if ($spinner !== null) {
            if (! in_array($spinner, ['line', 'dot', 'minidot', 'jump', 'pulse', 'points', 'globe', 'moon', 'monkey', 'meter', 'hamburger'])) {
                throw new Exception('Invalid spinner: ' + $spinner);
            }

            $command[] = '--spinner=' . escapeshellarg($spinner);
        }

        $command[] = '-- php -r "while(true) sleep(100);"';

        $pipes = [];
        $r = System::proc_open(implode(' ', $command), [STDIN, STDOUT, STDOUT], $pipes);

        return new Spinner($r);
    }


    protected static $executable = null;
    protected static function executable()
    {
        return static::$executable ?? (__DIR__ . '/../lib/gum/darwin/gum');
    }

    public static function useExecutable($path)
    {
        static::$executable = $path;
    }
}
