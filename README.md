MailOnline
==========

This README is designed to help you through the process of installing a copy of the project on your local machine and/or server.
Everything that is needed to make the app fully working is required to be described here.

* *Confluence*: https://webfit.atlassian.net/wiki/display/MailOnline
* *Btibucket*: https://bitbucket.org/webfitnz/mailonline

Branch management
-----------------

### Dev

* *dev* - Development branch. Internal testing environment (*mo-dev.webfit.co.nz*)
* *MO-xxx* - Feature development branches. Maintained by individual developer or group of developers.

### Ops

* *master* - Master branch. Production environment
* *staging* - Staging branch. UAT (User Acceptance Test) environment (*mo.webfit.co.nz*)

Any other branches will be used for individual feature developments. Branch names will usually be MO-xxx, though others are acceptable.

When a branch is ready for internal testing, merge it with dev branch. Multiple MO-xxx branch can be merged with dev branch.
When dev branch is ready for undergoing user acceptance test, merge *it* with staging branch.
When staging branch is ready for production release, merge *it* with master branch.

* Developers will work on _Dev_ (dev and MO-xxx) branches most of their time.
* Ops team will work on _Ops_ (maste, staging) branches.

Requirements
------------

### System Requirements

Everything should work on whatever system you'd like. However, the following is required before going further:

* Git
* PHP 5.5
* Node.js (required for bower to work and may be useful later)
* Fabric (and python) if you want to be able to deploy using our script
* Composer (refer to https://getcomposer.org/doc/00-intro.md, global install recommended)
* Bower (refer to http://bower.io, global install recommended)
* Nginx 1.4 (may work with older versions, at your own risk)
* Mysql 5.5+

### Standard Symfony Requirements

Referring to the official Symfony's read me:

Before starting coding, make sure that your local system is properly
configured for Symfony.

Execute the `check.php` script from the command line:

    php app/check.php

The script returns a status code of `0` if all mandatory requirements are met,
`1` otherwise.

Access the `config.php` script from a browser:

    http://localhost/path/to/symfony/app/web/config.php

If you get any warnings or recommendations, fix them before moving on.

Installation
------------

### System Locale

Check available locale in the targeted platform. 

    locale -a

The system locale time should be based on NZDT (ISO Time + 13 hours).
It is important to have NZ locale time regarding plan and invoicing date.
Create a .pam_enviroment in the home directory

    LANG=en_NZ.utf8
    LANGUAGE=en_NZ.utf8
    LC_ALL=en_NZ.utf8

And reboot the machine.

### Parameters

Copy `app/config/parameters.yml.dist` to `app/config/parameters.yml` and fit it to your needs.
Whenever you add a parameter, it is a good practice to add it as well in the `parameters.yml.dist`.

### Development environment

The development endpoint is provided in `web/app_dev.php.dist`. You should rename it to `app_dev.php`, as it will be ignored by git.
Please DON'T commit this file, as it may end on the production server and become a security breach.

### Installing vendors

Use composer to install dependencies. The following command will do the trick:

    composer install

Bower will provide our front-end dependencies. Use the following command to install the dependencies:

    bower install

### Databases installation

To create the database and its schema:

    ./app/console doctrine:database:create
    ./app/console doctrine:schema:create

### Cleaning your cache

If you have issues with permissions while cleaning cache, please see http://symfony.com/doc/current/book/installation.html#configuration-and-setup
Basic cache cleanup for your dev env:

    ./app/console cache:clear

Install assets:

    ./app/console assets:install

Dump them:

    ./app/console assetic:dump --force

Dump them and watch (updates the files automatically so you can test your updates without worrying):

    ./app/console assetic:dump --force --watch

### Generating search index

Next command will create search indexes:

    ./app/console fos:elastica:populate

### Fix file/directory permission

Run
    ./bin/fix-permission.sh,

or

    HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
    sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
    sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs

Philosophies
------------

* Coding standard for PHP is a mix of PSR-0, PSR-1, PSR-2 as explained at http://symfony.com/doc/current/contributing/code/standards.html
* Use camelCase for variables, and underscore for database column names
* For javascript, please try to follow Crockford's advices http://javascript.crockford.com/code.html
* DRY (Don't Repeat Yourself), KISS (Keep It Simple & Stupid), PHPDoc appreciated.
