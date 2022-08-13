<?php

use GumWrapper\System;

afterEach(function () {
    Mockery::close();
});

beforeEach(function () {
    $this->foreverScript = '-- php -r "while(true) sleep(100);"';
});

it('can spin', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('proc_open')
        ->withSomeOfArgs("gum spin {$this->foreverScript}")
        ->andReturns('');

    gum(true, $system)->spin();
});

it('can spin with title', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('proc_open')
        ->withSomeOfArgs('gum spin --title='.escapeshellarg('This is my loading message...')." {$this->foreverScript}")
        ->andReturns('');

    gum(true, $system)->spin('This is my loading message...');
});

it('can spin with spinner', function () {
    $system = Mockery::mock(System::class);
    $system->shouldReceive('proc_open')
        ->withSomeOfArgs('gum spin --spinner='.escapeshellarg('monkey')." {$this->foreverScript}")
        ->andReturns('');

    gum(true, $system)->spin(null, 'monkey');
});
