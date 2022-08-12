<?php

use GumWrapper\Gum;
use GumWrapper\System;

beforeEach(function () {
    $this->foreverScript = '-- php -r "while(true) sleep(100);"';
});

it('can spin', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('proc_open')
        ->withSomeOfArgs("gum spin {$this->foreverScript}")
        ->andReturns('');

    (new Gum)->spin();
});

it('can spin with title', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('proc_open')
        ->withSomeOfArgs("gum spin --title='This is my loading message...' {$this->foreverScript}")
        ->andReturns('');

    (new Gum)->spin('This is my loading message...');
});

it('can spin with spinner', function () {
    $mock = mock('alias:'.System::class);
    $mock->shouldReceive('proc_open')
        ->withSomeOfArgs("gum spin --spinner='monkey' {$this->foreverScript}")
        ->andReturns('');

    (new Gum)->spin(null, 'monkey');
});
