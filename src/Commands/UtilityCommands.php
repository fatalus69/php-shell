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
            if (!preg_match('/\.tar(\.gz|\.bz2|\.xz)?$/', $source)) {
                throw new WrongFileException('tar', pathinfo($source, PATHINFO_EXTENSION));
            }

            if (empty($destination)) {
                $destination = preg_replace('/\.tar(\.gz|\.bz2|\.xz)?$/', '', $source);
            }

            if (!is_dir($destination)) {
                mkdir($destination, 0777, true);
            }

            $flags .= 'xz';   
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

        $flags .= 'f';

        $output = null;
        $return_var = 0;

        if ($flags_int & EXTRACT) {
            exec("tar -{$flags} ".escapeshellarg($source)." -C ".escapeshellarg($destination), $output, $return_var);       
        } else {
            exec("tar -{$flags} ".escapeshellarg($destination)." ".escapeshellarg($source), $output, $return_var);
        }

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

        $this->checkCompressionSpeed($flags_int, $flags);

        if ($flags_int & DECOMPRESS) $flags = 'd';

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
        $exploded_source = explode('.', $source);
        $source_extension = $exploded_source[count($exploded_source) - 1];

        if( $source_extension !== 'gz') {
            throw new WrongFileException('gz', $source_extension);
        }

        //TODO: think of better solution
        
        return false;
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