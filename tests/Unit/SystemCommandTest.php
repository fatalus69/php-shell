<?php

use fatalus\PhpShell\Commands\SystemCommands;

test('whoami', function () {
    expect(SystemCommands::whoami())->toBe($_SERVER['USER']);
});

test('which', function () {
    $which_output = SystemCommands::which('php');
    expect($which_output)->toBeString();
    expect(file_exists($which_output))->toBeTrue();

    $which_fail = SystemCommands::which('nonexistentcommand12345');
    expect($which_fail)->toBeFalse();
});

test('whence', function () {
    $whence_output = SystemCommands::whence('php');
    expect($whence_output)->toBeString();
    expect(file_exists($whence_output))->toBeTrue();

    $whence_fail = SystemCommands::whence('nonexistentcommand12345');
    expect($whence_fail)->toBeFalse();
});