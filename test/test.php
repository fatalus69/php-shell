<?php

require_once __DIR__ . '/../vendor/autoload.php';

use fatalus\PhpShell\Shell;

$shell = new Shell();

echo $shell->which('php');

echo Shell::which('php');

// echo(Shell::which('mysqldump'));
// echo(Shell::which('php'));