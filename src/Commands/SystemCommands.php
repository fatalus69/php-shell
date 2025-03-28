<?php
namespace fatalus\PhpShell\Commands;

use Exception;

class SystemCommands {
    public static function whoami(): string
    {
        return trim(exec('whoami'));
    }

    public static function which(string $command): string|bool
    {
        $output = trim(exec("which ".escapeshellarg($command)));
        if (str_contains($output, 'not found') || empty($output)) {
            return false;
        }
        return $output;
    }

    public function whence(string $command): string|bool
    {
        $output = trim(exec("whence ".escapeshellarg($command)));
        return (empty($output)) ? false : $output;
    }

    public static function uptime(): string
    {
        return trim(exec('uptime'));
    }
    
    public static function hostname (): string 
    {
        return trim(exec('hostname'));
    }
}