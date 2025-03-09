<?php

namespace fatalus\PhpShell\Commands;

use fatalus\PhpShell\Commands\UtilityCommands;
use Exception;

class DatabaseCommands {

    private UtilityCommands $utility;

    public function __construct() {
        $this->utility = new UtilityCommands();
    }
    
    public function mysqldump() {
        $executable = $this->utility->which('mysqldump');

        if ($executable === null) {
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


    }

    public function pg_dump() {
        $executable = $this->utility->which('pg_dump');

        throw new Exception('Not Implemented');
    }

}