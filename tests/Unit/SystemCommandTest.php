<?php

use fatalus\PhpShell\Commands\SystemCommands;

test('whoami', function () {
    expect(SystemCommands::whoami())->toBe($_SERVER['USER']);
});
