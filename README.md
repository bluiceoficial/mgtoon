# MGTOON

MGTOON é uma biblioteca para trabalhar com Token-Oriented Object Notation no PHP.

## Installation

`composer require mugomes/mgtoon`

## Example

```
use MGTOON\MGTOON;

include_once(__DIR__ . '/vendor/autoload.php');


$toon = new MGTOON();

// Load TOON and primary key "name"
$toon->loadFile(__DIR__ . '/users.toon', 'name');

// Load TOON string and primary key "name"
$toon->loadTOON('user[name|email|active]
Maria|maria@localhost|1
João|joao@localhost|0', 'name');

// Added Fields and primary key "name"
$toon->create('user', ['name', 'email', 'active'], 'name');

// Added Items
$toon->add(['name' => 'Maria', 'email' => 'maria@localhost', 'active' => 1]);
$toon->add(['name' => 'João', 'email' => 'joao@localhost', 'active' => 0]);

// Query
echo "\nQuery\n";
print_r($toon->read());

// Update
echo "\n\nUpdate\n";
$toon->update('Maria', ['active' => 0]);

// Read
echo "\n\nRead\n";
print_r($toon->read('Maria'));

// Delete
echo "\n\nDelete\n";
$toon->delete('João');

// TOON
echo "\nTOON\n";
print_r($toon->toString());

// Validate
echo "\n\nValidate\n";
print_r($toon->validate($toon->toString(), 'name'));

// Save File
$toon->saveFile(__DIR__ . '/users.toon');
```

## Support

- GitHub Sponsors: https://github.com/sponsors/mugomes/
- More Options: https://www.mugomes.com.br/apoie.html

## License

The MGTOON is provided under:

[SPDX-License-Identifier: LGPL-2.1-only](https://github.com/mugomes/mgtoon/blob/main/LICENSE)

Beign under the terms of the GNU Lesser General Public License version 2.1 only.

All contributions to the MGTOON are subject to this license.
