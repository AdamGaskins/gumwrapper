<?php

use PhpGum\Gum;
use PhpGum\System;

it('can choose', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withArgs(["gum choose 'apple' 'banana' 'pear'"])
        ->andReturns('apple');

    Gum::choose(['apple', 'banana', 'pear']);
});

it('escapes arguments', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withArgs(["gum choose 'apple pie' 'banana' 'pear'"])
        ->andReturns('apple');

    Gum::choose(['apple pie', 'banana', 'pear']);
});
