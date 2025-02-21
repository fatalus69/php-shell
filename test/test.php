<?php

require_once __DIR__ . '/../vendor/autoload.php';

use fatalus\PhpShell\Shell;

$shell = new Shell();

echo $shell->tar('test.php', 'test.tar', EXTRACT, GZIP,  CREATE, VERBOSE);

echo(Shell::which('mysqldump'));
echo(Shell::which('php'));