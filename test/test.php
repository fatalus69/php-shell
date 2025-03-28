<?php

require_once __DIR__ . '/../vendor/autoload.php';

use fatalus\PhpShell\Shell;
use fatalus\PhpShell\Commands\UtilityCommands;

$shell = new Shell();

// echo $shell->tar('test.php', 'test.tar', EXTRACT, GZIP,  CREATE, VERBOSE);

// echo($shell->tar(__DIR__ . '/../test_zip', 'fuck_you_tar_test.tar.gz', CREATE, GZIP));
echo($shell->tar(__DIR__.'/../fuck_you_tar_test.tar.gz', LIB_ROOT.'/fuck_you_tarrrr_test', EXTRACT));


// echo(Shell::which('php'));