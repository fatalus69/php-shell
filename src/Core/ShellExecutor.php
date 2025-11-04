<?php

namespace fatalus\PhpShell\Core;

use RuntimeException;

class ShellExecutor
{
    public function run(string $command): array
    {
        $output = [];
        $status = 0;

        if (strtolower(PHP_OS_FAMILY) === 'windows') {
            throw new RuntimeException('Windows is not supported yet.');
        }

        // TODO: Windows support
        exec($command . ' 2>&1', $output, $status);

        return [
            'status' => $status,
            'output' => implode("\n", $output)
        ];
    }
}
