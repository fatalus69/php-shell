<?php 

namespace fatalus\PhpShell;

class UtilityCommands
{
    public static function whoami(): string
    {
        return exec('whoami');
    }

    public static function which(string $command): string|false
    {
        $output = exec("which ".escapeshellarg($command));
        return (!empty($output)) ? $output : false;
    }
}