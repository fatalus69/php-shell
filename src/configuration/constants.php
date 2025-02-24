<?php

namespace fatalus\PhpShell\Configuration;

// TAR constants
define('EXTRACT', 1); //-x
define('GZIP', 2); //-z
define('CREATE', 4); //-c
define('BZIP2', 8); //-j
define('VERBOSE', 16); //-v
define('FILE', 32); //-T

// GZIP constants
define('KEEP', 1); //-k
define('DECOMPRESS', 2); //-d
define('DIRECTORY', 4); //-r
define('CHECK_FILE', 8); //-t
define('QUICK', 16); //-1
define('SAFE', 32); //-9