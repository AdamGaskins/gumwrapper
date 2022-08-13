<?php

use GumWrapper\System;

afterEach(function () {
    Mockery::close();
});

it('can input', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs('gum input')
        ->andReturns('');

    gum(true, $system)->input();
});

it('includes options', function ($expect, $args) {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs('gum input'.$expect)
        ->andReturns('');

    gum(true, $system)->input(...$args);
})->with([
    [' --placeholder='.escapeshellarg('abc'), ['abc']],
    [' --prompt='.escapeshellarg('abc'), [null, 'abc']],
    [' --value='.escapeshellarg('abc'), [null, null, 'abc']],
    [' --char-limit=10', [null, null, null, 10]],
    [' --width=20', [null, null, null, null, 20]],
    ['', [null, null, null, null, null, false]],
    [' --password', [null, null, null, null, null, true]],
]);
