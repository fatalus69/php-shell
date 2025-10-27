<?php

namespace fatalus\PhpShell\Commands;

use fatalus\PhpShell\Core\ShellExecutor;

/**
 * Maybe return whole return array with status and output?
 */
class SystemCommands
{
    public static function whoami(): string
    {
        return new ShellExecutor()->run('whoami')['output'];
    }

    public static function which(string $command): bool|string
    {
        $output = new ShellExecutor()->run("which " . escapeshellarg($command));
        if (self::checkForError($output)) {
            return false;
        }

        return $output['output'];
    }

    /**
     * This only works on ZSH configurations.
     */
    public static function whence(string $command): bool|string
    {
        // Call 'which' if the current shell is not zsh
        if (strpos($_SERVER['SHELL'], 'zsh') === false) {
            return self::which($command);
        }

        $output = new ShellExecutor()->run("whence " . escapeshellarg($command));
        if (self::checkForError($output)) {
            return false;
        }

        return $output['output'];
    }

    public static function uptime(): ?int
    {
        $output = new ShellExecutor()->run('uptime -s');
        if (self::checkForError($output)) {
            return null;
        }

        $time = strtotime($output['output']);
        if (self::checkForError($output)) {
            return null;
        }

        return time() - $time;
    }

    private static function checkForError(array $result): bool
    {
        if ($result['output'] === false || empty($result['output']) || $result['status'] !== 0) {
            return true;
        }

        return false;
    }
}
