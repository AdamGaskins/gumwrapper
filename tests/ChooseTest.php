<?php

use PhpGum\Gum;
use PhpGum\System;

it('can choose', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum choose 'apple' 'banana' 'pear'")
        ->andReturns('');

    (new Gum)->choose(['apple', 'banana', 'pear']);
});

it('can have no limit', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum choose --no-limit 'apple' 'banana' 'pear'")
        ->andReturns('');

    (new Gum)->choose(['apple', 'banana', 'pear'], 0);
});

it('can have a limit', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum choose --limit 3 'apple' 'banana' 'pear'")
        ->andReturns('');

    (new Gum)->choose(['apple', 'banana', 'pear'], 3);
});

it('can have a height', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum choose --height 15 'apple' 'banana' 'pear'")
        ->andReturns('');

    (new Gum)->choose(['apple', 'banana', 'pear'], null, 15);
});

it('escapes arguments', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum choose 'apple pie' 'banana' 'pear'")
        ->andReturns('');

    (new Gum)->choose(['apple pie', 'banana', 'pear']);
});

it('escapes arguments with characters', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum choose 'apple '\'' pie' 'banana' 'pear'")
        ->andReturns('');

    (new Gum)->choose(['apple \' pie', 'banana', 'pear']);
});
