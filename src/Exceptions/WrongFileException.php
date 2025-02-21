<?php

namespace fatalus\PhpShell\Exceptions;

use Exception;
use Throwable;

class WrongFileException extends Exception {
    public function __construct(string $expected_file, string $actual_file, $code = 0, Throwable $previous = null) {

        $message = "Source file must be a {$expected_file}. Got {$actual_file} instead.\n";

        parent::__construct($message, $code, $previous);
    }
}