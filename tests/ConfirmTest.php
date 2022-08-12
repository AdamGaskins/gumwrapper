<?php

use GumWrapper\Gum;
use GumWrapper\System;

it('can confirm', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs('gum confirm')
        ->andReturns('');

    (new Gum)->confirm();
});

it('can confirm with message', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum confirm 'Are you sure?'")
        ->andReturns('');

    (new Gum)->confirm('Are you sure?');
});

it('can confirm with message and custom labels', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum confirm 'Are you sure?' --affirmative 'Yeah' --negative 'Nah'")
        ->andReturns('');

    (new Gum)->confirm('Are you sure?', 'Yeah', 'Nah');
});

it('can confirm with message and custom labels and default', function () {
    $mock = Mockery::mock('alias:'.System::class);
    $mock->shouldReceive('exec')
        ->withSomeOfArgs("gum confirm 'Are you sure?' --affirmative 'Yeah' --negative 'Nah' --default=0")
        ->andReturns('');

    (new Gum)->confirm('Are you sure?', 'Yeah', 'Nah', false);
});
