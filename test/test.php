<?php

require_once __DIR__ . '/../vendor/autoload.php';

use fatalus\PhpShell\Shell;


// var_dump(class_exists('fatalus\PhpShell\Commands\UtilityCommands'));
// die;
$shell = new Shell();

echo $shell->tar('test.php', 'test.tar', EXTRACT, GZIP,  CREATE, VERBOSE);

echo($shell->which('php'));
// echo(Shell::which('php'));