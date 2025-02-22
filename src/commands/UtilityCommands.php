<?php 

namespace fatalus\PhpShell;

use fatalus\PhpShell\Exceptions\WrongFileException;

class UtilityCommands
{
    public static function whoami(): string
    {
        return exec('whoami');
    }

    public static function which(string $command): string|false
    {
        $output = exec("which ".escapeshellarg($command));
        return (!empty($output)) ? $output : false;
    }
    
    public static function tar(string $source, string $destination = '', ...$options): string|false
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

        return exec("tar -{$flags} ".escapeshellarg($source)." ".escapeshellarg($destination));
    }
}