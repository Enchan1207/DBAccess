# DBAccess

## Overview

Database access utility library **for myself**.

**NOTE**

 - No warranty
 - Ugly code and implementation

## Installation

In `composer.json` in your project directory, please add:

```jsonc:composer.json
{
    "require": {
        // Please specify the latest version (now(2021.3) latest version is 1.0)
        "enchan1207/dbaccess": "^1.0",
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/Enchan1207/DBAccess"
        }
    ]
}
```

and execute `composer install`.

## Usage

The sample code is shown below:

```php:sample.php
require "vendor/autoload.php";

use \DBAccess\DBAccess;

$dbaccess = new DBAccess("mysql:dbname=TestDB;host=127.0.0.1;port=3306", "user", "password");
$dbaccess->execute("SELECT * FROM testTable WHERE id=:id;", ["id"=>1234]);

$records = $dbaccess->fetchAll();
foreach ($records as $key => $record) {
    print("Record ${key}:\n");
    foreach ($record as $key => $value) {
        print("$key:$value\n");
    }
    print("\n");
}
```

## LICENSE

This repository is published under MIT License.
In details, see [LICENSE](LICENSE).
