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

    public function which(string $command): string|bool
    {
        $output = exec("which ".escapeshellarg($command));
        return (!empty($output)) ? $output : false;
    }
    
    public function tar(string $source, string $destination = '', ...$options): bool //error
    {
        $flags = '';
        $flags_int = array_reduce($options, fn($carry, $item) => $carry | $item, 0);
        
        if ($flags_int & EXTRACT) { //only allow extraction when source is actually a tar file
            $source_extension = explode('.', $source)[1];
            if ($source_extension !== 'tar') {
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

        if ($flags_int & FILE) $flags .= 'T'; 
        if ($flags_int & GZIP) $flags .= 'z';
        if ($flags_int & BZIP2) $flags .= 'j';

        if ($flags_int & TAR_DECOMPRESS) $flags = 'xvZ';

        $flags .= 'f';

        $output = null;
        $return_var = 0;

        exec("tar -{$flags} ".escapeshellarg($destination)." ".escapeshellarg($source), $output, $return_var);

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
        if ($flags_int & DIRECTORY) $flags .= 'r';
        if ($flags_int & CHECK_GZIP) $flags .= 't';

        if ($flags_int & QUICK && $flags_int & SAFE) {
            throw new Exception('Cannot use both QUICK and SAFE flags at the same time');
        }
        
        if ($flags_int & DECOMPRESS) {
            $flags .= 'd';
            
            $destination_dir = dirname($destination);
            if (!is_dir(__DIR__.$destination_dir)) {
                mkdir(__DIR__.$destination_dir, 0755, true);
            }

            $destination = $destination_dir;
        }

        $this->checkCompressionSpeed($flags_int, $flags);

        $output = null;
        $return_var = 0;

        exec("gzip -{$flags} ".escapeshellarg($source)." > ".escapeshellarg($destination), $output, $return_var);

        if ($return_var !== 0) {
            throw new Exception("Error compressing file: " . implode("\n", $output));
        }

        return true;
    }

    public function gunzip(string $source): bool 
    {
        var_dump($source);

        $exploded_source = explode('.', $source);
        $source_extension = $exploded_source[count($exploded_source) - 1];

        if( $source_extension !== 'gz') {
            throw new WrongFileException('gz', $source_extension);
        }

        $destination = explode('.', $source)[0];
        
        return $this->gzip($source, $destination, DECOMPRESS);
    }

    public function zip(string $source, string $destination = '', ...$options): bool
    {
        $flags = '';
        $flags_int = array_reduce($options, fn($carry, $item) => $carry | $item, 0);

        if ($flags_int & UPDATE) $flags .= 'u';
        if ($flags_int & DELTE_SOURCE) $flags .= 'm';
        if ($flags_int & ENCRYPT) $flags .= 'e';
        if ($flags_int & CHECK_ZIP) $flags .= 'T';

        if ($destination === '') {
            $destination = $source . '.gz';
        }

        $this->checkCompressionSpeed($flags_int, $flags);
        $flags .= 'q';

        $output = null;
        $return_var = 0;

        exec("zip -{$flags} ".escapeshellarg($source)." ".escapeshellarg($destination), $output, $return_var);

        if ($return_var !== 0) {
            throw new Exception("Error compressing file: " . implode("\n", $output));
        }

        return true;
    }

    public function unzip(string $source, ...$options): bool
    {
        $flags = '';
        $flags_int = array_reduce($options, fn($carry, $item) => $carry | $item, 0);

        if ($flags_int & NO_OVERWRITE) $flags .= 'n';
        if ($flags_int & OVERWRITE) $flags .= 'o';

        $destination = reset(explode('.', $source));
      
        $output = null;
        $return_var = 0;

        exec("unzip -{$flags} ".escapeshellarg($source)." ".escapeshellarg($destination), $output, $return_var);

        if ($return_var !== 0) {
            throw new Exception("Error compressing file: " . implode("\n", $output));
        }

        return true;
    }

    private function checkCompressionSpeed(int $flags_int, string &$flags)
    {
        if ($flags_int & QUICK && $flags_int & SAFE) {
            throw new Exception('Cannot use both QUICK and SAFE flags at the same time');
        }

        if ($flags_int & QUICK) $flags .= '1';
        if ($flags_int & SAFE) $flags .= '9';

        if (!($flags_int & QUICK) && !($flags_int & SAFE)) {
            $flags .= '5';
        }
    }
}