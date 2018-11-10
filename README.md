# Call of Duty API Wrapper
An API wrapper for Call of Duty's Companion App API.

# Usage
Follow the code examples below to piece together a working example of how to use this library.

## Login
```php
use CallOfDuty\Client;

$client = new Client();
// Use Activision email and password to login.
$client->login('me@email.com', 'pa55w0rd');
```

## Setup User
```php
// Username and platform the user plays on.
$user = $client->user('tustin25', 'psn');
```
## Black Ops 4
```php
$bo4 = $user->blackOps4();
// Or alternatively
$bo4 = $user->bo4(); // Alias of blackOps4()
```

### Blackout
todo

### Multiplayer
todo

### Zombies
```php
$zm = $bo4->zombies();

// Spit out some user information
echo sprintf("Prestige %d, level %d\n", $zm->prestige(), $zm->level());
echo sprintf("\tKills - %d\n", $zm->lifetime()->kills());
echo sprintf("\tDowns - %d\n", $zm->lifetime()->downs());
echo sprintf("\tHeadshots - %d\n", $zm->lifetime()->headshots());
```

## WWII

todo


## Full code example
```php
<?php
require_once 'vendor/autoload.php';

use CallOfDuty\Client;

$client = new Client();
$client->login('me@email.com', 'pa55w0rd');

$zm = $client->user('tustin25', 'psn')->blackOps4()->zombies();

foreach ($zm->recentMatches() as $match) {
    echo sprintf(
        "%s - Round %d (%s)\n", 
        $match->map(),
        $match->roundReached(),
        $match->difficulty()
    );

    $stats = $match->playerStats();

    echo sprintf("\tKills - %d\n", $stats->kills());
    echo sprintf("\tDowns - %d\n", $stats->downs());
    echo sprintf("\tSpecialist Kills - %s\n", $stats->maxedSpecialWeaponKills());
}

echo sprintf("%s - Prestige %d, level %d\n", 'tustin25', $zm->prestige(), $zm->level());
echo sprintf("\tKills - %d\n", $zm->lifetime()->kills());
echo sprintf("\tDowns - %d\n", $zm->lifetime()->downs());
echo sprintf("\tHeadshots - %d\n", $zm->lifetime()->headshots());

```
