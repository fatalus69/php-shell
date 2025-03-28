## PHP-Shell by v0.1 by [fatalus](https://github.com/fatalus69)

Easy to use package to run useful Shell commonds from PHP.
Supports every PHP version subsequent to PHP 8.0.


### How to install

---

```sh

```

### How to use

```php
use fatalus\PhpShell\Shell;

// You cann call commands statically
Shell::whoami();

// Or you can call them by reference, whatever you prefer ;)
$shell = new Shell();
$shell->which('php');

// Or if you're only interested in specific Commands you can simply call them statically
use fatalus\PhpShell\SystemCommands;

SystemCommands::whoami();


use fatalus\PhpShell\UtilityCommands;

UtilityCommands::stat(__DIR__.DIRECTORY_SEPERATOR.'README.md')
```

---

### Availabe Calls


| Call                                    | Description                                                             | Return Type   |
| :-------------------------------------- | :---------------------------------------------------------------------- | :-----------: |
|**Utility Commands**|||
|UtilityCommands::tar()|De-/compress directories using the tar algorithm|__(bool)__|
|UtilityCommands::gzip()|De-/compress files using the gzip algorithm|__(bool)__|
|UtilityCommands::gunzip()| Decompress files using the gzip algorithm|__(bool)__|
|UtilityCommands::zip()|Compress files & Direcotories using the zip algorithm|__(bool)__|
|UtilityCommands::unzip()|Decompress files & Direcotories using the zip algorithm|__(bool)__|
|UtilityCommands::stat()|Display detailed file information|__(array)__|
|**System Commands**|||
|SystemCommands::which()|Returns the executable path of given program| __(bool \| string)__|
|SystemCommands::whence()|Returns the executable path of given program| __(bool \| string)__|
|SystemCommands::whoami()|Returns the current user| __(string)__ |
|SystemCommands::uptime()|Show system uptime|__(string)__|
|SystemCommands::hostname()|Show System hostname|__(string)__|
|**Database Commands**||               |
|DatabaseCommands::mysqldump()|Export MySQL Database|__(bool)__|
|DatabaseCommands::pg_dump()|Export PostgreSQL Database|__(null)__|