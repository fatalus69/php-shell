<?php

namespace fatalus\PhpShell\Core;

class ShellExecutor
{
    public function run(string $command): array
    {
        $output = [];
        $status = 0;

        // TODO: Windows support
        exec($command . ' 2>&1', $output, $status);

        return [
            'status' => $status,
            'output' => implode("\n", $output)
        ];
    }
}
