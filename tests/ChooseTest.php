<?php

use GumWrapper\Gum;
use GumWrapper\System;

it('can choose', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose', escapeshellarg('apple'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    (new Gum)->choose(['apple', 'banana', 'pear']);
});

it('can have no limit', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose --no-limit', escapeshellarg('apple'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    (new Gum)->choose(['apple', 'banana', 'pear'], 0);
});

it('can have a limit', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose --limit 3', escapeshellarg('apple'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    (new Gum)->choose(['apple', 'banana', 'pear'], 3);
});

it('can have a height', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose --height 15', escapeshellarg('apple'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    (new Gum)->choose(['apple', 'banana', 'pear'], null, 15);
});

it('escapes arguments', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose', escapeshellarg('apple pie'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    (new Gum)->choose(['apple pie', 'banana', 'pear']);
});

it('escapes arguments with characters', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose', escapeshellarg('apple \' pie'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    (new Gum)->choose(['apple \' pie', 'banana', 'pear']);
});
