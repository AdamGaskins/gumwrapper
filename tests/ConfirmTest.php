<?php

use GumWrapper\Gum;
use GumWrapper\System;

afterEach(function() {
    Mockery::close();
});

it('can confirm', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs('gum confirm')
        ->andReturns('');

    gum(true, $system)->confirm();
});

it('can confirm with message', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs('gum confirm '.escapeshellarg('Are you sure?'))
        ->andReturns('');

    gum(true, $system)->confirm('Are you sure?');
});

it('can confirm with message and custom labels', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs('gum confirm '.escapeshellarg('Are you sure?').' --affirmative '.escapeshellarg('Yeah').' --negative '.escapeshellarg('Nah'))
        ->andReturns('');

    gum(true, $system)->confirm('Are you sure?', 'Yeah', 'Nah');
});

it('can confirm with message and custom labels and default', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('exec')
        ->withSomeOfArgs('gum confirm '.escapeshellarg('Are you sure?').' --affirmative '.escapeshellarg('Yeah').' --negative '.escapeshellarg('Nah').' --default=0')
        ->andReturns('');

    gum(true, $system)->confirm('Are you sure?', 'Yeah', 'Nah', false);
});
