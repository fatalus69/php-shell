<?php

require_once __DIR__ . '/../vendor/autoload.php';

use fatalus\PhpShell\Shell;


// var_dump(class_exists('fatalus\PhpShell\Commands\UtilityCommands'));
// die;
$shell = new Shell();

// echo $shell->tar('test.php', 'test.tar', EXTRACT, GZIP,  CREATE, VERBOSE);

echo($shell->tar(__DIR__ . '/../test_zip', 'fuck_you_tar.tar.gz', GZIP, CREATE));

// echo(Shell::which('php'));