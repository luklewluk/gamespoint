# Games Point
[![Build Status](https://travis-ci.org/luklewluk/gamespoint.svg?branch=master)](https://travis-ci.org/luklewluk/gamespoint)

A Symfony based project to manage games collection

Laravel version is still available in "laravel" branch.

## Development
To run the project on your local machine you can easily execute `php bin/console server:run` as regular Symfony application.

### Vagrant
If your local environment is not configured you can use [Vagrant](https://www.vagrantup.com) to set up the project in 4 steps:

1) Add `192.168.10.10    gamespoint.local` to `/etc/hosts`.

2) Install dependencies and configure database
```
composer install
```

3) Prepare [Homestead](https://laravel.com/docs/master/homestead) configuration
```
php vendor/bin/homestead make
```

After that you will find `Homestead.yaml` file created. It contains Vagrant machine configuration. It does not require
any changes but it is worth to take a look and ensure the configuration will work with the local machine.

4) Create vagrant machine
```
vagrant up
```

Database parameters:

Host: 127.0.0.1 (default)

Login/pass: homestead/secret

Database: gamespoint

## Deployment
For this project [Deployer](http://deployer.org/) is used as a deployment tool. You can find the configuration in `deploy.php` file. Your servers list must be definied in `servers.yml`.
