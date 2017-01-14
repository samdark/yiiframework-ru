yiiframework.ru
===============

Source code for new version of [yiiframework.ru](http://yiiframework.ru/).

[![Join the chat at https://gitter.im/samdark/yiiframework-ru](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/samdark/yiiframework-ru?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Overview
--------

Project includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

Installation
------------

### 1. Install framework and dependencies

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this application template using the following command:

```
composer global require "fxp/composer-asset-plugin"
composer install
```

### 2. Initialize configs

Run `init` in the root directory. Choose development environment.

### 3. Database

Create a database. Copy `/config/system/db.php` to `/config/db.php`. Specify your database connection there.

Then apply migrations by running:

```
yii migrate
```

### 4. Setup webserver

Point your werbserver root to `web` directory.
There's [nginx config you can check](https://github.com/samdark/yiiframework-ru/tree/master/server/nginx).

Code style
----------

Code style used in this project is [PSR-2](http://www.php-fig.org/psr/psr-2/).