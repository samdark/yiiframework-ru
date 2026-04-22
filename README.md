yiiframework.ru
===============

Source code for new version of [yiiframework.ru](http://yiiframework.ru/).

[![Join the chat at https://gitter.im/samdark/yiiframework-ru](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/samdark/yiiframework-ru?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Overview
--------

Project includes a web application and a console application sharing the same
codebase and configuration directory.

Installation
------------

### 1. Install framework and dependencies

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Install dependencies with Composer:

```
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

Point your webserver document root to the `www` directory.
For containerized local development, prefer the FrankenPHP-based Docker setup described below.

Alternative installation (Vagrant)
----------------------------------

#### Manual for Linux/Unix users

1. Install [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
2. Install [Vagrant](https://www.vagrantup.com/downloads.html)
3. Create GitHub [personal API token](https://github.com/blog/1509-personal-api-tokens)
4. Prepare project:
   
   ```bash
   git clone https://github.com/samdark/yiiframework-ru.git
   cd yiiframework-ru/vagrant/config
   cp vagrant-local.example.yml vagrant-local.yml
   ```
   
5. Place your GitHub personal API token to `vagrant-local.yml`
6. Change directory to project root:

   ```bash
   cd yiiframework-ru
   ```

7. Run command:

   ```bash
   vagrant up
   ```
   
That's all. You just need to wait for completion!
After that you can access project locally by URL: http://l.yiiframework.ru
   
#### Manual for Windows users

1. Install [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
2. Install [Vagrant](https://www.vagrantup.com/downloads.html)
3. Reboot
4. Create GitHub [personal API token](https://github.com/blog/1509-personal-api-tokens)
5. Prepare project:
   * download repo [yiiframework-ru](https://github.com/samdark/yiiframework-ru/archive/master.zip)
   * unzip it
   * go into directory `yiiframework-ru-master/vagrant/config`
   * copy `vagrant-local.example.yml` to `vagrant-local.yml`

6. Place your GitHub personal API token to `vagrant-local.yml`

7. Open terminal (`cmd.exe`), **change directory to project root** and run command:

   ```bash
   vagrant up
   ```
   
   (You can read [here](http://www.wikihow.com/Change-Directories-in-Command-Prompt) how to change directories in command prompt) 

That's all. You just need to wait for completion!
After that you can access project locally by URL: http://l.yiiframework.ru

### Alternative installation (Docker)

```bash
make setup
```

This single command starts the FrankenPHP-based containers, installs dependencies, initializes configs and runs migrations.
After that, use `make up` / `make down` to start and stop the environment.

To open the running app in your default browser:

```bash
make open
```

If the environment is already running and you only need to prepare the application, use:

```bash
make bootstrap
```

Access the site at **http://localhost:8080**

Production-like docker environment is available separately:

```bash
make prod-up
```

This builds the production image locally, applies `environments/prod` during image build, starts the app together with its own database and runs migrations.
Access it at **http://localhost:8081** and stop it with `make prod-down`.

Rollbar is optional for local production-like runs. To enable it, create `docker/prod/override.env` from `docker/prod/override.env.example` and set `ROLLBAR_ACCESS_TOKEN` there.
If the file is missing or the token is empty, `make prod-up` prints a warning and starts with Rollbar disabled.

Run `make help` to see all available commands.

Optional installation steps
---------------------------

### 1. Configure GitHub application

Create new GitHub OAuth application: https://github.com/settings/applications/new - authorization callback URL must lead to local site domain.
Copy `/config/system/authclients.php` to `/config/authclients.php`. Specify your application settings there.

Code style
----------

Code style used in this project is [PSR-2](http://www.php-fig.org/psr/psr-2/).
