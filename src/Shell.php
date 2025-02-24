<?php

namespace fatalus\PhpShell;

require_once __DIR__.'/configuration/constants.php';

use fatalus\PhpShell\Commands\UtilityCommands;

final class Shell {
    
    private UtilityCommands $utility;

    public function __construct()
    {
        $this->utility = new UtilityCommands();
    }

    public function whoami(): string
    {
        return $this->utility->whoami();
    }

    public function which(string $command): string|false
    {
        return $this->utility->which($command);
    }

    public function tar(string $source, string $destination = '', ...$options): string|false
    {
        return $this->utility->tar($source, $destination, ...$options);
    }
}