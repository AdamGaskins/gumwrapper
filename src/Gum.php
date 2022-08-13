<?php

namespace GumWrapper;

use Exception;

class Gum
{
    protected $executable = null;

    protected $system = null;

    protected $binManager = null;

    public function __construct($executable = null, $system = null, $binManager = null)
    {
        $this->executable = $executable;

        $this->system = $system ?? new System;

        $this->binManager = ($binManager ?? new BinManager);
        $this->binManager->installBinary();
    }

    /**
     * @param  array<string>  $options
     * @param  int|null  $limit
     * @param  int|null  $height
     * @return string|false
     */
    public function choose($options, int $limit = null, int $height = null)
    {
        $options = array_map(function ($arg) {
            return escapeshellarg($arg);
        }, $options);

        $command = [$this->executable(), 'choose'];

        if ($limit !== null) {
            $command[] = $limit < 1 ? '--no-limit' : ('--limit '.intval($limit));
        }

        if ($height !== null) {
            $command[] = '--height '.intval($height);
        }

        $command[] = implode(' ', $options);

        $output = [];
        $returnCode = null;
        $result = $this->system->exec(implode(' ', $command), $output, $returnCode);

        return $returnCode === 0 ? $result : false;
    }

    /**
     * @param  string|null  $prompt
     * @param  string|null  $affirmativeText
     * @param  string|null  $negativeText
     * @param  bool|null  $default
     * @return bool
     */
    public function confirm(string $prompt = null, string $affirmativeText = null, string $negativeText = null, bool $default = null)
    {
        $command = [$this->executable(), 'confirm'];

        $this->add($command, $prompt, fn () => escapeshellarg($prompt));
        $this->add($command, $affirmativeText, fn () => '--affirmative '.escapeshellarg($affirmativeText));
        $this->add($command, $negativeText, fn () => '--negative '.escapeshellarg($negativeText));
        $this->add($command, $default, fn () => '--default='.((bool) $default ? '1' : '0'));

        $output = [];
        $resultCode = null;
        $this->system->exec(implode(' ', $command), $output, $resultCode);

        return $resultCode === 0;
    }

    /**
     * @param  string|null  $placeholder
     * @param  string|null  $prompt
     * @param  string|null  $initialValue
     * @param  int|null  $charLimit
     * @param  int|null  $width
     * @param  bool|null  $password
     * @return string|false
     */
    public function input(string $placeholder = null, string $prompt = null, string $initialValue = null, int $charLimit = null, int $width = null, bool $password = null)
    {
        $command = [$this->executable(), 'input'];

        $this->add($command, $placeholder, fn () => '--placeholder='.escapeshellarg($placeholder));
        $this->add($command, $prompt, fn () => '--prompt='.escapeshellarg($prompt));
        $this->add($command, $initialValue, fn () => '--value='.escapeshellarg($initialValue));
        $this->add($command, $charLimit, fn () => '--char-limit='.intval($charLimit));
        $this->add($command, $width, fn () => '--width='.intval($width));
        $this->add($command, fn () => $password, fn () => '--password');

        $output = [];
        $resultCode = null;
        $text = $this->system->exec(implode(' ', $command), $output, $resultCode);

        return $resultCode === 0 ? $text : false;
    }

    public function spin(string $title = null, string $spinner = null)
    {
        $command = [$this->executable(), 'spin'];

        $this->add($command, $title, fn () => '--title='.escapeshellarg($title));

        if ($spinner !== null) {
            if (! in_array($spinner, ['line', 'dot', 'minidot', 'jump', 'pulse', 'points', 'globe', 'moon', 'monkey', 'meter', 'hamburger'])) {
                throw new Exception('Invalid spinner: ' + $spinner);
            }

            $command[] = '--spinner='.escapeshellarg($spinner);
        }

        $command[] = '-- php -r "while(true) sleep(100);"';

        $pipes = [];
        $r = $this->system->proc_open(implode(' ', $command), [STDIN, STDOUT, STDOUT], $pipes);

        return new Spinner($r);
    }

    public function version()
    {
        return $this->system->exec($this->executable().' --version');
    }

    protected function executable()
    {
        if ($this->executable) {
            return $this->executable;
        }

        return $this->binManager->getBinaryPath();
    }

    protected function add(&$array, $ifNotNull, callable $callable)
    {
        if (is_callable($ifNotNull) && ! $ifNotNull()) {
            return;
        } elseif ($ifNotNull === null) {
            return;
        }

        $array[] = $callable();
    }
}
