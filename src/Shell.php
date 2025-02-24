<?php

namespace fatalus\PhpShell;

require_once __DIR__.'/configuration/constants.php';

use fatalus\PhpShell\Commands\UtilityCommands;

/**
 * @method static string whoami() Calls whoami() from UtilityCommands
 * @method static string which(string $command) Calls UtilityCommands::which() from UtilityCommands
 * @method string whoami() Calls whoami() from UtilityCommands
 * @method string which(string $command) Calls which() from UtilityCommands
 */

final class Shell {
    
    private static array $commands = [];
    private array $instanceCommands = [];

    public function __construct()
    {
        self::initializeCommands(); 
        $this->instanceCommands = self::$commands;
    }

    private static function initializeCommands()
    {
        if (empty(self::$commands)) {
            self::$commands['utility'] = new UtilityCommands();
        }
    }

    public function __call($name, $arguments)
    {
        foreach ($this->instanceCommands as $command) {
            if (method_exists($command, $name)) {
                return $command->$name(...$arguments);
            }
        }
        throw new \BadMethodCallException("Method '$name' not found in any command classes.");
    }

    public static function __callStatic($name, $arguments)
    {
        self::initializeCommands();
        foreach (self::$commands as $command) {
            if (method_exists($command, $name)) {
                return $command->$name(...$arguments);
            }
        }
        throw new \BadMethodCallException("Static method '$name' not found in any command classes.");
    }
}