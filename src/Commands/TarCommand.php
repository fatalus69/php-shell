<?php

namespace fatalus\PhpShell\Commands;

use fatalus\PhpShell\Core\ShellExecutor;

class TarCommand
{
    public const EXTRACT = 1;
    public const CREATE = 2;
    public const LIST_FILES = 4;
    public const VERBOSE = 8;
    public const KEEP = 16;
    public const GZIP = 32;
    public const BZIP2 = 64;

    public static function run(string $filepath, int $options = 0, ?string $target = null): array
    {
        $option_string = self::parseOptions($options);
        $command = "tar -{$option_string}f " . escapeshellarg($filepath);

        // if its being extracted, set target directory
        if ($target !== null && str_contains($option_string, 'x')) {
            $command .= ' -C ' . escapeshellarg($target);
        }

        return new ShellExecutor()->run($command);
    }

    private static function parseOptions(int $options): string
    {
        $option_string = '';

        if ($options & self::CREATE) {
            $option_string .= 'c';
        }
        if ($options & self::EXTRACT) {
            $option_string .= 'x';
        }
        if ($options & self::LIST_FILES) {
            $option_string .= 't';
        }
        if ($options & self::VERBOSE) {
            $option_string .= 'v';
        }
        if ($options & self::GZIP) {
            $option_string .= 'z';
        }
        if ($options & self::BZIP2) {
            $option_string .= 'j';
        }

        return $option_string;
    }
}
