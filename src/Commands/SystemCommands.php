<?php

namespace fatalus\PhpShell\Commands;

use fatalus\PhpShell\Core\ShellExecutor;

class SystemCommands {
    public static function whoami(): string
    {
        return (new ShellExecutor()->run('whoami'));
    }

    public static function which(string $command): string|bool
    {
        $output = (new ShellExecutor()->run("which " . escapeshellarg($command)));
        if (empty($output)) {
            return false;
        }
        return $output;
    }

    public function whence(string $command): string|bool
    {
        $output = (new ShellExecutor()->run("whence " . escapeshellarg($command)));
        if (empty($output)) {
            return false;
        }
        return $output;
    }

    public static function uptime(): ?int
    {
        $output = (new ShellExecutor()->run('uptime --pretty')); 
        $exploded_output = explode(" ", $output);
        $time = (int)trim($exploded_output[1]);
        $identifier = trim($exploded_output[2]);

        switch (strtolower($identifier)) {
            case 'seconds':
                return $time;
                break;
            case 'minutes':
                return $time * 60;
                break;
            case 'hours':
                $time * 60 * 60;
            
            default:
                return null;
        }
    }
}