<?php 

namespace fatalus\PhpShell\Commands;

use fatalus\PhpShell\Exceptions\WrongFileException;
use Exception;

class UtilityCommands
{
    public function whoami(): string
    {
        return exec('whoami');
    }

    public function which(string $command): string|false
    {
        $output = exec("which ".escapeshellarg($command));
        return (!empty($output)) ? $output : false;
    }
    
    public function tar(string $source, string $destination = '', ...$options): bool
    {
        $flags = '';
        $flags_int = array_reduce($options, fn($carry, $item) => $carry | $item, 0);
        
        if ($flags_int & EXTRACT) { //only allow extraction when source is actually a tar file
            $source_extension = explode('.', $source)[1];
            if( $source_extension !== 'tar') {
                throw new WrongFileException('tar', $source_extension);
            }

            if ($destination === '') {
                $destination = explode('.', $source)[0];
            }

            $flags .= 'x';   
        }


        if ($flags_int & CREATE) {
            if ($destination === '') {
                $destination = $source . '.tar' . (($flags_int & GZIP) ? '.gz' : '');
            }
            $flags .= 'c';
        }

        if ($flags_int & CREATE) $flags .= 'c';        
        if ($flags_int & FILE) $flags .= 'T'; 
        if ($flags_int & GZIP) $flags .= 'z';
        if ($flags_int & BZIP2) $flags .= 'j';
        if ($flags_int & VERBOSE) $flags .= 'v'; //actually pretty useless in here cause we don't want massive output

        $flags .= 'f';

        $output = null;
        $return_var = 0;

        exec("tar -{$flags} ".escapeshellarg($source)." ".escapeshellarg($destination), $output, $return_var);

        if ($return_var !== 0) {
            throw new Exception("Error compressing file: " . implode("\n", $output));
        }

        return true;
    }


    public function gzip(string $source, string $destination = '', ...$options): bool
    {
        $flags = '';
        $flags_int = array_reduce($options, fn($carry, $item) => $carry | $item, 0);

        if ($flags_int & KEEP) $flags .= 'k';
        if ($flags_int & DECOMPRESS) $flags .= 'd';
        if ($flags_int & DIRECTORY) $flags .= 'r';
        if ($flags_int & CHECK_FILE) $flags .= 't';

        if ($flags_int & QUICK && $flags_int & SAFE) {
            throw new Exception('Cannot use both QUICK and SAFE flags at the same time');
        } 

        if ($flags_int & QUICK) $flags .= '1';
        if ($flags_int & SAFE) $flags .= '9';

        if (!($flags_int & QUICK) && !($flags_int & SAFE)) {
            $flags .= '5';
        }

        if ($destination === '') {
            $destination = $source . '.gz';
        }

        $output = null;
        $return_var = 0;

        exec("gzip -{$flags} ".escapeshellarg($source)." > ".escapeshellarg($destination), $output, $return_var);

        if ($return_var !== 0) {
            throw new Exception("Error compressing file: " . implode("\n", $output));
        }

        return true;
    }






    public function zip(string $source, string $destination = '', ...$options): string|false
    {


        return true;
    }
}