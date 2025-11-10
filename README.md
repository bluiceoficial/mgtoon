# MGToon

MGToon é uma biblioteca para trabalhar com Token-Oriented Object Notation no PHP.

## Installation

`composer require mugomes/mgtoon`

## Example

```
use MGToon\MGToon;

include_once(__DIR__ . '/vendor/autoload.php');

// Added Fields and primary key "name"
$toon = new MGToon('user', ['name', 'email', 'active'], 'name');

// Added Items
$toon->create(['name' => 'Maria', 'email' => 'maria@localhost', 'active' => 1]);
$toon->create(['name' => 'João', 'email' => 'joao@localhost', 'active' => 0]);

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
```

## Support

- GitHub Sponsors: https://github.com/sponsors/mugomes/
- More Options: https://mugomes.github.io/apoie.html

## License

The MGToon is provided under:

[SPDX-License-Identifier: LGPL-2.1-only](https://github.com/mugomes/mgtoon/blob/main/LICENSE)

Beign under the terms of the GNU Lesser General Public License version 2.1 only.

All contributions to the MGToon are subject to this license.
