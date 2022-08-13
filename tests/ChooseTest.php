<?php

use GumWrapper\Gum;
use GumWrapper\System;

afterEach(function() {
    Mockery::close();
});

it('can choose', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose', escapeshellarg('apple'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    gum(true, $system)->choose(['apple', 'banana', 'pear']);
});

it('can have no limit', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose --no-limit', escapeshellarg('apple'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    gum(true, $system)->choose(['apple', 'banana', 'pear'], 0);
});

it('can have a limit', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose --limit 3', escapeshellarg('apple'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    gum(true, $system)->choose(['apple', 'banana', 'pear'], 3);
});

it('can have a height', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose --height 15', escapeshellarg('apple'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    gum(true, $system)->choose(['apple', 'banana', 'pear'], null, 15);
});

it('escapes arguments', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose', escapeshellarg('apple pie'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    gum(true, $system)->choose(['apple pie', 'banana', 'pear']);
});

it('escapes arguments with characters', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs(implode(' ', ['gum choose', escapeshellarg('apple \' pie'), escapeshellarg('banana'), escapeshellarg('pear')]))
        ->andReturns('');

    gum(true, $system)->choose(['apple \' pie', 'banana', 'pear']);
});
