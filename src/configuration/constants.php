<?php

namespace fatalus\PhpShell\Configuration;

/** TAR constants */
define('EXTRACT', 1); //-x
define('GZIP', 2); //-z
define('CREATE', 4); //-c
define('BZIP2', 8); //-j
define('VERBOSE', 16); //-v
define('FILE', 32); //-T

/** GZIP constants */
define('KEEP', 1); //-k
define('DECOMPRESS', 2); //-d
define('DIRECTORY', 4); //-r
define('CHECK_GZIP', 8); //-t
define('QUICK', 16); //-1 also usable for zip
define('SAFE', 32); //-9 also usable for zip

/** ZIP constants */
define('UPDATE', 1); //-u
define('DELTE_SOURCE', 2); //-m
define('ENCRYPT', 4); //-e
define('CHECK_ZIP', 8); //-T

/** UNZIP constants */
define('NO_OVERWRITE', 1); //-n
define('OVERWRITE', 2); //-o without prompt