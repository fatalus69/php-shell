<?php

namespace fatalus\PhpShell\Commands;

use fatalus\PhpShell\Core\ShellExecutor;

class SystemCommands
{
    public static function whoami(): string
    {
        return new ShellExecutor()->run('whoami');
    }

    public static function which(string $command): bool|string
    {
        $output = (new ShellExecutor()->run("which " . escapeshellarg($command)));
        if (empty($output)) {
            return false;
        }

        return $output;
    }

    public function whence(string $command): bool|string
    {
        $output = (new ShellExecutor()->run("whence " . escapeshellarg($command)));
        if (empty($output)) {
            return false;
        }

        return $output;
    }

    public static function uptime(): ?int
    {
        $output = (new ShellExecutor()->run('uptime -s'));
        if (empty($output)) {
            return null;
        }

        $time = strtotime($output);
        if ($time === false) {
            return null;
        }

        return time() - $time;
    }
}
