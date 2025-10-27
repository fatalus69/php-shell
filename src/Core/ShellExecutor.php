<?php

namespace fatalus\PhpShell\Core;

use RuntimeException;

class ShellExecutor
{
    public function run(string $command): string
    {
        $output = [];
        $status = 0;

        // TODO: Windows support
        exec($command . ' 2>&1', $output, $status);

        // if ($status !== 0) {
        //     throw new RuntimeException("Command failed: {$command}\nOutput: " . implode("\n", $output));
        // }

        //maybe return formatted array with keys like status, output, error, etc.
        return trim(implode("\n", $output));
    }
}
