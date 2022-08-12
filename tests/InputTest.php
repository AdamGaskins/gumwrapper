<?php

use GumWrapper\Gum;
use GumWrapper\System;

it('can input', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs('gum input')
        ->andReturns('');

    (new Gum)->input();
});

it('includes options', function ($expect, $args) {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs('gum input'.$expect)
        ->andReturns('');

    (new Gum)->input(...$args);
})->with([
    [" --placeholder=" . escapeshellarg('abc'), ['abc']],
    [" --prompt=" . escapeshellarg('abc'), [null, 'abc']],
    [" --value=" . escapeshellarg('abc'), [null, null, 'abc']],
    [' --char-limit=10', [null, null, null, 10]],
    [' --width=20', [null, null, null, null, 20]],
    ['', [null, null, null, null, null, false]],
    [' --password', [null, null, null, null, null, true]],
]);
