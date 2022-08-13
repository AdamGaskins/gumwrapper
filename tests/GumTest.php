<?php

use GumWrapper\BinManager;

it('downloads binary for this platform', function() {
    $binPath = (new BinManager)->getBinaryPath();
    if (file_exists($binPath)) {
        unlink($binPath);
    }

    expect(file_exists($binPath))->toBeFalse();

    gum();

    expect(file_exists($binPath))->toBeTrue();
    expect(exec($binPath . ' --version'))
        ->toBeString()
        ->toContain('gum version v' . BinManager::GUM_VERSION);
});

it('can get version', function () {
    $version = gum()->version();

    expect($version)
        ->toBeString()
        ->toContain('gum version v' . BinManager::GUM_VERSION);
});
