<?php

namespace fatalus\PhpShell;

class Shell
{
    public function __call($method, $arguments)
    {
        return self::__callStatic($method, $arguments);
    }

    public static function __callStatic($method, $arguments) 
    {
        $categories = self::getClasses();

        foreach ($categories as $class) {
            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], $arguments);
            }
        }

        throw new \BadMethodCallException("Method {$method} does not exist.");
    }

    public static function getClasses(): array
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