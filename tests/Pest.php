<?php

use GumWrapper\BinManager;
use GumWrapper\Gum;
use GumWrapper\System;

function gum($mockBinary = false, $system = null, $binManager = null)
{
    if ($mockBinary) {
        $system ??= Mockery::mock(System::class);
        $system->shouldReceive('exec')->andReturns('')->zeroOrMoreTimes();
        $binManager ??= Mockery::mock(BinManager::class);
        $binManager->shouldReceive('installBinary')->zeroOrMoreTimes();
    }

    return new Gum($mockBinary ? 'gum' : null, $system, $binManager);
}
