<?php

namespace fatalus\PhpShell;

require_once __DIR__.'/../configuration/constants.php';

class Shell
{
    public function __call($method, $arguments)
    {
        return self::__callStatic($method, $arguments);
    }

    public static function __callStatic($method, mixed $arguments) 
    {
        foreach (self::getClasses() as $class) {
            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], $arguments);
            }
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    private static function getClasses(): array
    {
        $class_names = [];

        foreach(new \DirectoryIterator(__DIR__) as $file) {
            if ($file->isFile() && $file->getExtension() === 'php' && $file->getBasename() !== 'Shell.php') {
                $class_names[] = "fatalus\\PhpShell\\".$file->getBasename('.php');
            }
        }

        return $class_names;
    }
}