# PHP Supervisor

A simple supervisor tool that allows to run PHP long running scripts through crontab.

## Requirements

- PHP 5.6+

## Installing

Use Composer to install it:

```
composer require filippo-toso/php-supervisor
```

## Using It

Create a simple PHP script with a code like the following:

```
use FilippoToso\PhpSupervisor\Supervisor;

Supervisor::run(function() {
    // Do your long lived stuff here    
}, __DIR__ . '/lock.dat', __DIR__ . '/stop.dat');

```

Then call the script every minute from the crontab. The code in the closure will be kept running untill the $stopFile specified in the third parameter exists (`stop.dat` in the example). 