<?php

namespace fatalus\PhpShell;

function determineCurrentShell(): ?string
{
    $pid = getmypid();
    $ppid = function_exists('posix_getppid') ? posix_getppid() : (int)trim(exec("ps -o ppid= -p " . escapeshellarg($pid)));

    $shell = null;
    if (is_readable("/proc/{$ppid}/comm")) {
        $shell = trim(@file_get_contents("/proc/{$ppid}/comm"));
    } elseif (is_readable("/proc/{$ppid}/cmdline")) {
        $cmdline = @file_get_contents("/proc/{$ppid}/cmdline");
        if ($cmdline !== false) {
            $parts = explode("\0", $cmdline);
            $shell = basename($parts[0]);
        }
    }

    if (empty($shell)) {
        $out = trim(exec("ps -p " . escapeshellarg($ppid) . " -o comm="));
        if ($out !== '') {
            $shell = $out;
        }
    }

    return $shell;
}
