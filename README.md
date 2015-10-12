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

Create a database. By this moment you should have `common/config/main-local.php`. Specify your database connection there.

Then apply migrations by running:

```
yii migrate
```

### 4. Setup webserver

Create two hosts. One should point to `frontend/web`, another to `backend/web`.
There's [nginx config you can check](https://github.com/samdark/yiiframework-ru/tree/development/server/nginx).

Directory structure
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests
    codeception/         contains tests developed with Codeception PHP Testing Framework
```
