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

// Or if you're only interested in specific Commands you can simply call them like this:
use fatalus\PhpShell\UtilityCommands;

UtilityCommands::whoami();
```

---

### Availabe Calls


| Call                                    | Description                                                             | Return Type   |
| :-------------------------------------- | :---------------------------------------------------------------------- | :-----------: |
| **Utility Commands**                    |                                                                         |               |
| UtilityCommands::whoami()               | Return the current user                                                 |  __(string)__ |
| UtilityCommands::which()                | Returns the executable path of given program if installed               |  __(string)__ |
| UtilityCommands::tar()                  | De-/compress directories using the tar algorithm                        |  __(bool)__   |
| UtilityCommands::gzip()                 | De-/compress files using the gzip algorithm                             |  __(bool)__   |
| UtilityCommands::gunzip()               | Decompress files using the gzip algorithm                               |  __(bool)__   |
| UtilityCommands::zip()                  | Compress files & Direcotories using the zip algorithm                   |  __(bool)__   |
| UtilityCommands::unzip()                | Decompress files & Direcotories using the zip algorithm                 |  __(bool)__   |
| **Database Commands**                   |                                                                         |               |
| DatabaseCommands::mysqldump()           | Export MySQL Database                                                   |  __(bool)__   |
| DatabaseCommands::pg_dump()             | Export PostgreSQÖ Database                                              |  __(null)__   |