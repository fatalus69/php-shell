<?php

namespace fatalus\PhpShell\Commands;

use fatalus\PhpShell\Commands\SystemCommands;
use Exception;

class DatabaseCommands {

    private SystemCommands $system;

    public function __construct() {
        $this->system = new SystemCommands();
    }
    
    public static function mysqldump() {
        $executable = self::$system->which('mysqldump');

        if ($executable === false) {
            throw new Exception('mysqldump not found');
        }

        //TODO: dynamically get database credentials depending on the environment

        $host = 'localhost';
        $user = 'root';
        $password = 'password';
        $database = 'database_name';
        $outputFile = '/path/to/output.sql';

        $command = sprintf(
            '%s -h %s -u %s -p%s %s > %s',
            $executable,
            $host,
            $user,
            $password,
            $database,
            $outputFile
        );


        $output = null;
        $return_var = 0;

        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            throw new Exception('mysqldump failed');
        }

        return $output;
    }

    public static function pg_dump() {
        $executable = self::$system->which('pg_dump');

        if ($executable === false) {
            throw new Exception('pg_dump not found');
        }

        throw new Exception('Not Implemented');
    }

}