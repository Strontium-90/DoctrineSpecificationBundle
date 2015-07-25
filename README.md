StrontiumPjaxBundle
===================
Helpers for improve [Symfony 2](https://github.com/symfony/symfony) performance when working under Vagrant environment.

Using Symfony2 inside Vagrant can be slow due to synchronisation delay incurred by NFS. To avoid this, both locations have been moved to a shared memory segment under ``/dev/shm/%your_app_name%``.

To view the application logs, run the following commands:

```bash
$ tail -f /dev/shm/%your_app_name%/logs/prod.log
$ tail -f /dev/shm/%your_app_name%/logs/dev.log
```

Installation
------------
Add to `composer.json`:

``` json
{
    "require": {
        "strontium/symfony-vagrant": "*"
    }
}
```

Usage
------------
Extend yor Kernel from VagrantAwareKernel:

``` php
<?php
// app/AppKernel.php

use Strontium\SymfonyVagrant\Kernel\VagrantAwareKernel;

class AppKernel extends VagrantAwareKernel

```

If you using PHPStrorm and want to have copy of Symfony cache in your host machine, add next scripts to `composer.json`:

``` json
    "scripts": {
        "post-install-cmd": [
            "Strontium\\SymfonyVagrant\\Composer\\ScriptHandler::cacheWarmupOnVagrant"
        ],
        "post-update-cmd": [
            "Strontium\\SymfonyVagrant\\Composer\\ScriptHandler::cacheWarmupOnVagrant"
        ]
    }
```
